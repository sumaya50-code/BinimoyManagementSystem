<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{SavingsAccount, SavingsTransaction, SavingsWithdrawalRequest, CompanyFund, Member, CashAsset, CashTransaction};
use Barryvdh\DomPDF\Facade\Pdf;
use Yajra\DataTables\DataTables;

class SavingsController extends Controller
{
    public function __construct()
    {
        // Viewing dashboard and statements
        $this->middleware('permission:saving-list|saving-view', ['only' => ['index', 'show', 'statement']]);


        $this->middleware('permission:saving-create', ['only' => ['store']]);

        // Approve deposit
        $this->middleware('permission:saving-approve', ['only' => ['approveDeposit']]);

        // Post monthly interest
        $this->middleware('permission:saving-post-interest', ['only' => ['postInterest']]);

        // Withdrawal request
        $this->middleware('permission:saving-withdraw', ['only' => ['withdrawalRequest']]);

        // Approve withdrawal
        $this->middleware('permission:saving-approve-withdraw', ['only' => ['approveWithdrawal']]);

        // Generate voucher
        $this->middleware('permission:saving-voucher', ['only' => ['voucher']]);

        // Edit or delete transactions (optional)
        $this->middleware('permission:saving-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:saving-delete', ['only' => ['destroy']]);
    }

    // Dashboard
    public function index()
    {
        $accounts = SavingsAccount::with('member')->get();
        $transactions = SavingsTransaction::with('account.member')->get();
        return view('admin.savings.index', compact('accounts', 'transactions'));
    }

    // DataTables for Pending Deposits
    public function getPendingDepositsData()
    {
        $query = SavingsTransaction::with('account.member')
            ->where('type', 'deposit')
            ->where('status', 'pending');

        // Handle search
        if (request()->has('search') && !empty(request('search')['value'])) {
            $search = request('search')['value'];
            $query->where(function ($q) use ($search) {
                $q->whereHas('account.member', function ($subQ) use ($search) {
                    $subQ->where('name', 'like', '%' . $search . '%');
                })
                    ->orWhere('amount', 'like', '%' . $search . '%')
                    ->orWhereRaw("DATE_FORMAT(transaction_date, '%d %b, %Y') LIKE ?", ['%' . $search . '%']);
            });
        }

        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('member_name', function ($transaction) {
                /** @var \App\Models\SavingsTransaction $transaction */
                return $transaction->account->member->name;
            })
            ->addColumn('amount_formatted', function ($transaction) {
                /** @var \App\Models\SavingsTransaction $transaction */
                return '৳ ' . number_format($transaction->amount, 2);
            })
            ->addColumn('transaction_date_formatted', function ($transaction) {
                /** @var \App\Models\SavingsTransaction $transaction */
                return \Carbon\Carbon::parse($transaction->transaction_date)->format('d M, Y');
            })
            ->addColumn('action', function ($transaction) {
                /** @var \App\Models\SavingsTransaction $transaction */
                return '<a href="' . route('savings.approveDeposit', $transaction->id) . '" class="btn btn-success btn-sm px-3">Approve</a>';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    // Withdrawal Requests Page
    public function withdrawals()
    {
        $requests = SavingsWithdrawalRequest::with('member')->get();
        return view('admin.savings.withdrawals', compact('requests'));
    }

    // Deposit Entry (Pending)
    public function store(Request $request)
    {
        $request->validate([
            'member_id' => 'required',
            'amount' => 'required|numeric|min:1'
        ]);

        $account = SavingsAccount::firstOrCreate(
            ['member_id' => $request->member_id],
            ['balance' => 0, 'interest_rate' => 5]
        );

        // Ensure account number exists for display and reference
        if (empty($account->account_no)) {
            $account->update(['account_no' => 'SA' . str_pad($account->id, 6, '0', STR_PAD_LEFT)]);
        }

        SavingsTransaction::create([
            'savings_account_id' => $account->id,
            'type' => 'deposit',
            'amount' => $request->amount,
            'remarks' => 'Savings Deposit',
            'status' => 'pending',
            'transaction_date' => now()
        ]);

        return back()->with('success', 'Deposit submitted for approval');
    }

    // Approve Deposit
    public function approveDeposit($id)
    {
        $txn = SavingsTransaction::findOrFail($id);
        if ($txn->type != 'deposit' || $txn->status != 'pending') {
            return back()->with('error', 'Invalid transaction');
        }
        $txn->update(['status' => 'approved']);
        $txn->account->increment('balance', $txn->amount);

        // Update company fund balance
        $companyFund = CompanyFund::firstOrCreate([], ['balance' => 0]);
        $companyFund->increment('balance', $txn->amount);

        // Create cash transaction for inflow
        $cashAsset = CashAsset::first();
        if ($cashAsset) {
            CashTransaction::create([
                'cash_asset_id' => $cashAsset->id,
                'type' => 'inflow',
                'amount' => $txn->amount,
                'reference_type' => 'savings_deposit',
                'reference_id' => $txn->id,
                'remarks' => 'Savings deposit approved'
            ]);
            $cashAsset->increment('balance', $txn->amount);
        }

        return back()->with('success', 'Deposit approved and balance updated');
    }

    // Post Interest
    public function postInterest()
    {
        $accounts = SavingsAccount::all();
        foreach ($accounts as $account) {
            $interest = ($account->balance * $account->interest_rate) / 100 / 12;
            if ($interest > 0) {
                SavingsTransaction::create([
                    'savings_account_id' => $account->id,
                    'type' => 'deposit',
                    'amount' => $interest,
                    'transaction_date' => now(),
                    'remarks' => 'Monthly Interest',
                    'status' => 'approved'
                ]);
                $account->increment('balance', $interest);
            }
        }
        return back()->with('success', 'Interest posted');
    }

    // Withdrawal Request
    public function withdrawalRequest(Request $request)
    {
        $request->validate([
            'member_id' => 'required',
            'amount' => 'required|numeric|min:1'
        ]);

        // Ensure requested amount does not exceed savings balance
        $account = SavingsAccount::where('member_id', $request->member_id)->first();
        if (!$account || $request->amount > $account->balance) {
            return back()->with('error', 'Insufficient savings balance for this withdrawal request');
        }

        SavingsWithdrawalRequest::create([
            'member_id' => $request->member_id,
            'amount' => $request->amount,
            'status' => 'pending'
        ]);

        return back()->with('success', 'Withdrawal request submitted');
    }

    // Approve Withdrawal
    public function approveWithdrawal($id)
    {
        $withdrawal = SavingsWithdrawalRequest::findOrFail($id);
        $account = SavingsAccount::where('member_id', $withdrawal->member_id)->first();
        $companyFund = CompanyFund::firstOrCreate([], ['balance' => 0]);

        if ($withdrawal->amount > $account->balance) {
            return back()->with('error', 'Insufficient balance');
        }

        if ($companyFund->balance < $withdrawal->amount) {
            return back()->with('error', 'Company fund has insufficient balance to process this withdrawal');
        }

        $withdrawal->update([
            'status' => 'approved',
            'approved_by' => auth()->id(),
            'approved_at' => now()
        ]);

        $account->decrement('balance', $withdrawal->amount);
        $companyFund->decrement('balance', $withdrawal->amount);

        $txn = SavingsTransaction::create([
            'savings_account_id' => $account->id,
            'type' => 'withdrawal',
            'amount' => $withdrawal->amount,
            'transaction_date' => now(),
            'remarks' => 'Savings Withdrawal',
            'status' => 'approved'
        ]);

        // Create cash transaction for outflow
        $cashAsset = CashAsset::first();
        if ($cashAsset) {
            CashTransaction::create([
                'cash_asset_id' => $cashAsset->id,
                'type' => 'outflow',
                'amount' => $withdrawal->amount,
                'reference_type' => 'savings_withdrawal',
                'reference_id' => $txn->id,
                'remarks' => 'Savings withdrawal approved'
            ]);
            $cashAsset->decrement('balance', $withdrawal->amount);
        }

        // Notify member about approved withdrawal (email + sms if available)
        $member = $withdrawal->member;
        $channels = ['email', 'sms'];
        $toEmail = $member->email;
        $toPhone = $member->phone;

        \App\Services\NotificationService::send('withdrawal_approved', [$toEmail, $toPhone], $channels, 'Your withdrawal of ' . number_format($withdrawal->amount, 2) . ' has been approved.', ['withdrawal_id' => $withdrawal->id]);

        return back()->with('success', 'Withdrawal approved');
    }

    // Statement
    public function statement($memberId)
    {
        $account = SavingsAccount::where('member_id', $memberId)->with('transactions')->firstOrFail();
        return view('admin.savings.statement', compact('account'));
    }

    // Voucher
    public function voucher($id)
    {
        $withdrawal = SavingsWithdrawalRequest::with('member', 'approver')->findOrFail($id);
        $pdf = Pdf::loadView('admin.savings.voucher', compact('withdrawal'));
        return $pdf->download('withdrawal-voucher.pdf');
    }

    // Savings Accounts Summary
    public function summary()
    {
        $accounts = SavingsAccount::with('member')->get();
        $totalAccounts = $accounts->count();
        $totalBalance = $accounts->sum('balance');
        $totalDeposits = SavingsTransaction::where('type', 'deposit')->where('status', 'approved')->sum('amount');
        $totalWithdrawals = SavingsTransaction::where('type', 'withdrawal')->where('status', 'approved')->sum('amount');

        return view('admin.savings.summary', compact('accounts', 'totalAccounts', 'totalBalance', 'totalDeposits', 'totalWithdrawals'));
    }

    // Resource Methods
    public function show($id)
    {
        return $this->statement($id);
    }
    public function edit($id) {}
    public function update(Request $request, $id) {}
    public function destroy($id) {}
}
