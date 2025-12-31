<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use App\Models\Member;
use App\Models\LoanProposal;
use App\Models\CompanyFund;
use App\Models\CashAsset;
use App\Models\CashTransaction;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class LoanController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:loan-list|loan-create|loan-edit|loan-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:loan-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:loan-edit', ['only' => ['edit', 'update', 'toggleStatus']]);
        $this->middleware('permission:loan-delete', ['only' => ['destroy']]);
        $this->middleware('permission:loan-approve', ['only' => ['approveProposal']]);
        $this->middleware('permission:loan-disburse', ['only' => ['disburse']]);
    }
    public function index()
    {
        return view('admin.loans.index');
    }

    public function getData()
    {
        $loans = Loan::with('member')->latest();

        return DataTables::of($loans)
            ->addIndexColumn()
            ->addColumn('member_name', fn($row) => $row->member->name ?? 'N/A')
            ->addColumn('status', function ($row) {
                $colors = [
                    'Pending'   => 'bg-yellow-500',
                    'Approved'  => 'bg-blue-500',
                    'Active'    => 'bg-green-600',
                    'Completed' => 'bg-gray-600',
                    'Overdue'   => 'bg-red-600'
                ];
                $color = $colors[$row->status] ?? 'bg-gray-500';
                return "<span class='px-2 py-1 rounded text-white $color'>{$row->status}</span>";
            })
            ->addColumn('loan_details', function ($row) {
                return '<a href="' . route('loans.show', $row->id) . '"
                        class="btn btn-info btn-sm px-2 py-1">Details</a>';
            })
            ->addColumn('action', function ($row) {
                return '
                <div class="flex gap-2 justify-center">
                    <a href="' . route('loans.edit', $row->id) . '"
                       class="text-blue-600 hover:underline">Edit</a>

                    <a href="javascript:void(0)"
                       data-url="' . route('loans.destroy', $row->id) . '"
                       class="text-red-600 delete-btn hover:underline">
                        Delete
                    </a>
                </div>
            ';
            })
            ->rawColumns(['status', 'action', 'loan_details'])
            ->make(true);
    }


    public function create()
    {
        $members = Member::all();
        return view('admin.loans.create', compact('members'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'member_id' => 'required',
            'loan_amount' => 'required|numeric',
            'interest_rate' => 'required|numeric',
            'installment_count' => 'required|numeric',
            'installment_type' => 'required',
            'status' => 'required'
        ]);

        Loan::create([
            'member_id' => $request->member_id,
            'loan_amount' => $request->loan_amount,
            'interest_rate' => $request->interest_rate,
            'installment_count' => $request->installment_count,
            'installment_type' => $request->installment_type,
            'status' => strtolower($request->status)
        ]);

        return redirect()->route('loans.index')->with('success', 'Loan created successfully');
    }

    public function show(Loan $loan)
    {
        return view('admin.loans.show', compact('loan'));
    }

    // Approve proposal (simple toggle on LoanProposal)
    public function approveProposal($id)
    {
        $proposal = LoanProposal::findOrFail($id);
        if ($proposal->status !== 'pending') {
            return back()->with('error', 'Proposal cannot be approved');
        }
        $proposal->update(['status' => 'approved']);

        // Notify member
        $member = $proposal->member;
        if ($member) {
            \App\Services\NotificationService::send('loan_proposal_approved', [$member->email, $member->phone], ['email', 'sms'], 'Your loan proposal has been approved.', ['proposal_id' => $proposal->id]);
        }

        return back()->with('success', 'Proposal approved');
    }

    // Disburse an approved proposal and create loan schedule
    public function disburse(Request $request, $proposalId)
    {
        $proposal = LoanProposal::findOrFail($proposalId);
        if ($proposal->status !== 'approved') {
            return back()->with('error', 'Proposal must be approved before disbursing');
        }

        $request->validate([
            'disbursed_amount' => 'required|numeric|min:1',
            'installment_count' => 'required|integer|min:1',
            'installment_type' => 'required|in:daily,weekly,monthly',
            'interest_rate' => 'nullable|numeric|min:0'
        ]);

        $companyFund = CompanyFund::firstOrCreate([], ['balance' => 0]);
        if ($companyFund->balance < $request->disbursed_amount) {
            return back()->with('error', 'Insufficient company fund to disburse');
        }

        $loan = Loan::create([
            'loan_proposal_id' => $proposal->id,
            'member_id' => $proposal->member_id,
            'loan_amount' => $proposal->proposed_amount,
            'disbursed_amount' => $request->disbursed_amount,
            'remaining_amount' => $request->disbursed_amount,
            'interest_rate' => $request->interest_rate ?? 0,
            'installment_count' => $request->installment_count,
            'installment_type' => $request->installment_type,
            'disbursement_date' => now(),
            'status' => 'disbursed'
        ]);

        // reduce company fund
        $companyFund->decrement('balance', $request->disbursed_amount);

        // log cash transaction
        $cashAsset = CashAsset::first();
        if ($cashAsset) {
            CashTransaction::create([
                'cash_asset_id' => $cashAsset->id,
                'type' => 'outflow',
                'amount' => $request->disbursed_amount,
                'reference_type' => 'loan',
                'reference_id' => $loan->id,
                'remarks' => 'Loan disbursement'
            ]);
            $cashAsset->decrement('balance', $request->disbursed_amount);
        }

        // generate installments
        $loan->generateInstallments($loan->disbursement_date);

        // Notify member about disbursement
        $member = $proposal->member;
        if ($member) {
            \App\Services\NotificationService::send('loan_disbursed', [$member->email, $member->phone], ['email', 'sms'], 'Your loan has been disbursed for amount ' . number_format($request->disbursed_amount, 2), ['loan_id' => $loan->id]);
        }

        return back()->with('success', 'Loan disbursed and schedule created');
    }

    // Field officer collection entry
    public function collectInstallment(Request $request)
    {
        $request->validate([
            'loan_installment_id' => 'required|exists:loan_installments,id',
            'amount' => 'required|numeric|min:1'
        ]);

        $collection = \App\Models\LoanCollection::create([
            'loan_installment_id' => $request->loan_installment_id,
            'collector_id' => auth()->id(),
            'amount' => $request->amount,
            'status' => 'pending',
            'transaction_date' => now(),
            'remarks' => $request->remarks ?? null
        ]);

        return back()->with('success', 'Collection submitted for verification');
    }

    // Admin verification of a collection
    public function verifyCollection($id)
    {
        $collection = \App\Models\LoanCollection::findOrFail($id);
        if ($collection->status !== 'pending') {
            return back()->with('error', 'Collection not pending');
        }

        $installment = $collection->installment;
        $loan = $installment->loan;

        // Check if installment is overdue and apply penalty if needed
        $today = now()->toDateString();
        if ($installment->due_date < $today && $installment->status === 'pending') {
            // Calculate penalty based on loan's penalty rate
            $penaltyRate = $loan->penalty_rate ?? 0.5; // Default 0.5%
            $overdueDays = now()->diffInDays($installment->due_date);
            $penalty = round(($installment->amount * $penaltyRate * $overdueDays) / 100, 2);

            // Apply penalty to installment
            $installment->penalty_amount += $penalty;
            $installment->status = 'overdue';
            $installment->save();

            // Notify member about penalty
            $member = $loan->member;
            if ($member) {
                $message = 'Penalty of ' . number_format($penalty, 2) . ' applied to installment #' . $installment->installment_no . ' (Overdue days: ' . $overdueDays . ')';
                \App\Services\NotificationService::send('loan_penalty_applied', [$member->email, $member->phone], ['email', 'sms'], $message, ['installment_id' => $installment->id]);
            }
        }

        // mark verified
        $collection->update(['status' => 'verified', 'verified_by' => auth()->id(), 'verified_at' => now()]);

        // update installment
        $installment->increment('paid_amount', $collection->amount);
        if ($installment->paid_amount >= ($installment->amount + $installment->penalty_amount)) {
            $installment->status = 'paid';
            $installment->paid_at = now();
            $installment->save();
        }

        // update loan remaining (principal + penalty)
        $totalAmount = $collection->amount;
        $loan->decrement('remaining_amount', $totalAmount);

        // check if loan is completed
        if ($loan->remaining_amount <= 0) {
            $loan->status = 'Completed';
            $loan->save();
        }

        // increase company fund
        $company = CompanyFund::firstOrCreate([], ['balance' => 0]);
        $company->increment('balance', $totalAmount);

        // cash transaction
        $cashAsset = CashAsset::first();
        if ($cashAsset) {
            CashTransaction::create([
                'cash_asset_id' => $cashAsset->id,
                'type' => 'inflow',
                'amount' => $totalAmount,
                'reference_type' => 'loan_collection',
                'reference_id' => $collection->id,
                'remarks' => 'Loan collection verified'
            ]);
            $cashAsset->increment('balance', $totalAmount);
        }

        // Notify member about collection verification
        $member = $loan->member;
        if ($member) {
            \App\Services\NotificationService::send('loan_collection_verified', [$member->email, $member->phone], ['email', 'sms'], 'Your collection of amount ' . number_format($totalAmount, 2) . ' has been verified.', ['collection_id' => $collection->id]);
        }

        return back()->with('success', 'Collection verified and loan updated');
    }

    public function edit(Loan $loan)
    {
        $members = Member::all();
        return view('admin.loans.edit', compact('loan', 'members'));
    }

    public function update(Request $request, Loan $loan)
    {
        $request->validate([
            'member_id' => 'required',
            'loan_amount' => 'required|numeric',
            'interest_rate' => 'required|numeric',
            'installment_count' => 'required|numeric',
            'installment_type' => 'required',
            'status' => 'required'
        ]);

        $loan->update($request->only(['member_id', 'loan_amount', 'interest_rate', 'installment_count', 'installment_type', 'status']));

        return redirect()->route('loans.index')->with('success', 'Loan updated successfully');
    }

    public function destroy(Loan $loan)
    {
        $loan->delete();
        return response()->json(['message' => 'Loan deleted successfully']);
    }
}
