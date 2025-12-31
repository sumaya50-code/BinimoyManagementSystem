<?php

namespace App\Http\Controllers;

use App\Models\LoanProposal;
use App\Models\Member;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class LoanProposalController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:loan-proposal-list|loan-proposal-create|loan-proposal-edit|loan-proposal-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:loan-proposal-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:loan-proposal-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:loan-proposal-delete', ['only' => ['destroy']]);
        $this->middleware('permission:loan-proposal-audit', ['only' => ['approveAudit', 'rejectAudit']]);
        $this->middleware('permission:loan-proposal-manager-review', ['only' => ['approveManagerReview', 'rejectManagerReview']]);
        $this->middleware('permission:loan-proposal-area-approve', ['only' => ['approveAreaManager', 'rejectAreaManager']]);
    }

    public function index()
    {
        return view('admin.loan_proposals.index');
    }

    public function getData()
    {
        $proposals = LoanProposal::with('member')->latest();

        return DataTables::of($proposals)
            ->addIndexColumn()
            ->addColumn('member_name', fn($row) => $row->member->name ?? 'N/A')
            ->addColumn('status', function ($row) {
                $colors = [
                    'pending' => 'bg-yellow-500',
                    'under_audit' => 'bg-blue-500',
                    'manager_review' => 'bg-purple-500',
                    'area_manager_approval' => 'bg-indigo-500',
                    'approved' => 'bg-green-500',
                    'rejected' => 'bg-red-500'
                ];
                $color = $colors[$row->status] ?? 'bg-gray-500';
                return "<span class='px-2 py-1 rounded text-white $color'>{$row->status}</span>";
            })
            ->addColumn('action', function ($row) {
                $actions = '<div class="flex gap-2 justify-center">';
                $actions .= '<a href="' . route('loan_proposals.show', $row->id) . '" class="btn btn-info btn-sm">View</a>';
                if ($row->status === 'pending') {
                    $actions .= '<a href="' . route('loan_proposals.edit', $row->id) . '" class="btn btn-warning btn-sm">Edit</a>';
                    $actions .= '<a href="javascript:void(0)" data-url="' . route('loan_proposals.destroy', $row->id) . '" class="btn btn-danger btn-sm delete-btn">Delete</a>';
                }
                $actions .= '</div>';
                return $actions;
            })
            ->rawColumns(['status', 'action'])
            ->make(true);
    }

    public function create()
    {
        $members = Member::all();
        return view('admin.loan_proposals.create', compact('members'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'member_id' => 'required|exists:members,id',
            'proposed_amount' => 'required|numeric|min:1',
            'business_type' => 'required|string|max:255',
            'loan_proposal_date' => 'required|date',
            'savings_balance' => 'required|numeric|min:0',
            'dps_balance' => 'nullable|numeric|min:0',
            'previous_loans' => 'nullable|array',
            'previous_loans.*.installment_no' => 'nullable|integer|min:1',
            'previous_loans.*.loan_amount' => 'nullable|numeric|min:0',
            'previous_loans.*.disbursement_date' => 'nullable|date',
            'previous_loans.*.repayment_date' => 'nullable|date',
            'previous_loans.*.probable_repayment_date' => 'nullable|date',
            'previous_loans.*.loan_status' => 'nullable|in:active,completed,defaulted',
            'applicant_signature' => 'nullable|string|max:255',
            'employee_signature' => 'nullable|string|max:255',
            'audited_verified' => 'nullable|string|max:255',
            'approved_amount_audit' => 'nullable|numeric|min:0',
            'auditor_signature' => 'nullable|string|max:255',
            'verified_by_manager' => 'nullable|string|max:255',
            'approved_amount_manager' => 'nullable|numeric|min:0',
            'manager_signature' => 'nullable|string|max:255',
            'verified_by_area_manager' => 'nullable|string|max:255',
            'approved_amount_area' => 'nullable|numeric|min:0',
            'date_approved' => 'nullable|date',
            'authorized_signatory_signature' => 'nullable|string|max:255'
        ]);

        // Business rule validations
        $member = Member::find($request->member_id);

        // Check minimum savings balance (at least 10% of proposed loan amount)
        $minSavingsRequired = $request->proposed_amount * 0.1;
        if (($request->savings_balance + $request->dps_balance) < $minSavingsRequired) {
            return back()->withErrors(['savings_balance' => 'Member must have at least ' . number_format($minSavingsRequired, 2) . ' in savings/DPS (10% of proposed loan amount)'])->withInput();
        }

        // Check if member has any defaulted previous loans
        $previousLoans = $request->previous_loans ?? [];
        foreach ($previousLoans as $prevLoan) {
            if (isset($prevLoan['loan_status']) && $prevLoan['loan_status'] === 'defaulted') {
                return back()->withErrors(['previous_loans' => 'Cannot create loan proposal for member with defaulted previous loans'])->withInput();
            }
        }

        $loanProposal = LoanProposal::create([
            'member_id' => $request->member_id,
            'proposed_amount' => $request->proposed_amount,
            'status' => 'pending',
            'business_type' => $request->business_type,
            'loan_proposal_date' => $request->loan_proposal_date,
            'savings_balance' => $request->savings_balance,
            'dps_balance' => $request->dps_balance,
            'applicant_signature' => $request->applicant_signature,
            'employee_signature' => $request->employee_signature,
            'audited_verified' => $request->audited_verified,
            'approved_amount_audit' => $request->approved_amount_audit,
            'auditor_signature' => $request->auditor_signature,
            'verified_by_manager' => $request->verified_by_manager,
            'approved_amount_manager' => $request->approved_amount_manager,
            'manager_signature' => $request->manager_signature,
            'verified_by_area_manager' => $request->verified_by_area_manager,
            'approved_amount_area' => $request->approved_amount_area,
            'date_approved' => $request->date_approved,
            'authorized_signatory_signature' => $request->authorized_signatory_signature
        ]);

        // Note: Guarantors will be added separately after proposal creation

        // Create previous loans if provided
        if ($request->has('previous_loans') && is_array($request->previous_loans)) {
            foreach ($request->previous_loans as $previousLoanData) {
                if (!empty(array_filter($previousLoanData))) {
                    \App\Models\PreviousLoan::create([
                        'loan_proposal_id' => $loanProposal->id,
                        'installment_no' => $previousLoanData['installment_no'] ?? null,
                        'loan_amount' => $previousLoanData['loan_amount'] ?? null,
                        'disbursement_date' => $previousLoanData['disbursement_date'] ?? null,
                        'repayment_date' => $previousLoanData['repayment_date'] ?? null,
                        'probable_repayment_date' => $previousLoanData['probable_repayment_date'] ?? null,
                        'loan_status' => $previousLoanData['loan_status'] ?? null
                    ]);
                }
            }
        }

        return redirect()->route('loan_proposals.index')->with('success', 'Loan proposal created successfully');
    }

    public function show(LoanProposal $loanProposal)
    {
        return view('admin.loan_proposals.show', compact('loanProposal'));
    }

    public function edit(LoanProposal $loanProposal)
    {
        if ($loanProposal->status !== 'pending') {
            return redirect()->route('loan_proposals.index')->with('error', 'Only pending proposals can be edited');
        }
        $members = Member::all();
        return view('admin.loan_proposals.edit', compact('loanProposal', 'members'));
    }

    public function update(Request $request, LoanProposal $loanProposal)
    {
        if ($loanProposal->status !== 'pending') {
            return redirect()->route('loan_proposals.index')->with('error', 'Only pending proposals can be updated');
        }

        $request->validate([
            'member_id' => 'required|exists:members,id',
            'proposed_amount' => 'required|numeric|min:1',
            'business_type' => 'required|string|max:255',
            'loan_proposal_date' => 'nullable|date',
            'savings_balance' => 'required|numeric|min:0',
            'dps_balance' => 'nullable|numeric|min:0'
        ]);

        $loanProposal->update($request->only(['member_id', 'proposed_amount', 'business_type', 'loan_proposal_date', 'savings_balance', 'dps_balance']));

        return redirect()->route('loan_proposals.index')->with('success', 'Loan proposal updated successfully');
    }

    public function destroy(LoanProposal $loanProposal)
    {
        if ($loanProposal->status !== 'pending') {
            return response()->json(['error' => 'Only pending proposals can be deleted'], 403);
        }

        $loanProposal->delete();
        return response()->json(['message' => 'Loan proposal deleted successfully']);
    }

    // Approval workflow methods
    public function submitForAudit(LoanProposal $loanProposal)
    {
        // Check if proposal has at least one guarantor
        if ($loanProposal->guarantors()->count() === 0) {
            return back()->with('error', 'Cannot submit for audit: At least one guarantor is required');
        }

        if (!$loanProposal->submitForAudit()) {
            return back()->with('error', 'Cannot submit for audit');
        }
        return back()->with('success', 'Proposal submitted for audit');
    }

    public function approveAudit(LoanProposal $loanProposal)
    {
        if (!$loanProposal->approveAudit()) {
            return back()->with('error', 'Cannot approve audit');
        }
        return back()->with('success', 'Audit approved, sent to manager review');
    }

    public function rejectAudit(Request $request, LoanProposal $loanProposal)
    {
        if (!$loanProposal->rejectAudit($request->reason)) {
            return back()->with('error', 'Cannot reject audit');
        }
        return back()->with('success', 'Proposal rejected during audit');
    }

    public function approveManagerReview(LoanProposal $loanProposal)
    {
        if (!$loanProposal->approveManagerReview()) {
            return back()->with('error', 'Cannot approve manager review');
        }
        return back()->with('success', 'Manager review approved, sent to area manager');
    }

    public function rejectManagerReview(Request $request, LoanProposal $loanProposal)
    {
        if (!$loanProposal->rejectManagerReview($request->reason)) {
            return back()->with('error', 'Cannot reject manager review');
        }
        return back()->with('success', 'Proposal rejected during manager review');
    }

    public function approveAreaManager(Request $request, LoanProposal $loanProposal)
    {
        $maxAmount = $loanProposal->approved_amount_area ?: $loanProposal->approved_amount_manager ?: $loanProposal->proposed_amount;
        $request->validate([
            'disbursed_amount' => 'required|numeric|min:1|max:' . $maxAmount,
            'installment_count' => 'required|integer|min:1',
            'installment_type' => 'required|in:daily,weekly,monthly',
            'interest_rate' => 'nullable|numeric|min:0'
        ]);

        if (!$loanProposal->approveAreaManager()) {
            return back()->with('error', 'Cannot approve area manager');
        }

        // Auto-disburse the loan
        $companyFund = \App\Models\CompanyFund::firstOrCreate([], ['balance' => 0]);
        if ($companyFund->balance < $request->disbursed_amount) {
            return back()->with('error', 'Insufficient company fund to disburse');
        }

        $loan = \App\Models\Loan::create([
            'loan_proposal_id' => $loanProposal->id,
            'member_id' => $loanProposal->member_id,
            'loan_amount' => $loanProposal->proposed_amount,
            'disbursed_amount' => $request->disbursed_amount,
            'remaining_amount' => $request->disbursed_amount,
            'interest_rate' => $request->interest_rate ?? 0,
            'installment_count' => $request->installment_count,
            'installment_type' => $request->installment_type,
            'disbursement_date' => now(),
            'status' => \App\Models\Loan::STATUS_ACTIVE
        ]);

        // reduce company fund
        $companyFund->decrement('balance', $request->disbursed_amount);

        // log cash transaction
        $cashAsset = \App\Models\CashAsset::first();
        if ($cashAsset) {
            \App\Models\CashTransaction::create([
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
        $member = $loanProposal->member;
        if ($member) {
            \App\Services\NotificationService::send('loan_disbursed', [$member->email, $member->phone], ['email', 'sms'], 'Your loan has been disbursed for amount ' . number_format($request->disbursed_amount, 2), ['loan_id' => $loan->id]);
        }

        return back()->with('success', 'Area manager approved and loan disbursed successfully');
    }

    public function rejectAreaManager(Request $request, LoanProposal $loanProposal)
    {
        if (!$loanProposal->rejectAreaManager($request->reason)) {
            return back()->with('error', 'Cannot reject area manager');
        }
        return back()->with('success', 'Proposal rejected by area manager');
    }

    public function generatePdf(LoanProposal $loanProposal)
    {
        $pdf = \PDF::loadView('admin.loan_proposals.pdf', compact('loanProposal'));
        return $pdf->download('loan_proposal_' . $loanProposal->id . '.pdf');
    }

    public function generateGuarantorPdf(LoanProposal $loanProposal)
    {
        $pdf = \PDF::loadView('admin.loan_proposals.guarantor_pdf', compact('loanProposal'));
        return $pdf->download('guarantor_form_' . $loanProposal->id . '.pdf');
    }

    public function getSavingsBalance(Request $request)
    {
        $memberId = $request->member_id;
        \Log::info("Getting savings balance for member_id: " . $memberId);
        \Log::info("Request data: ", $request->all());

        $savingsAccount = \App\Models\SavingsAccount::where('member_id', $memberId)->first();

        if ($savingsAccount) {
            // Use the balance field directly from SavingsAccount
            $balance = $savingsAccount->balance ?? 0;

            \Log::info("Savings balance: " . $balance);

            return response()->json([
                'savings_balance' => (float) $balance
            ]);
        }

        \Log::info("No savings account found for member");
        return response()->json([
            'savings_balance' => 0
        ]);
    }
}
