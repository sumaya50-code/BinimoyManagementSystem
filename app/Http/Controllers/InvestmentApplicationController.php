<?php

namespace App\Http\Controllers;

use App\Models\InvestmentApplication;
use App\Models\InvestmentWithdrawalRequest;
use App\Models\Member;
use App\Models\Partner;
use App\Models\CompanyFund;
use App\Models\CashAsset;
use App\Models\CashTransaction;
use Illuminate\Http\Request;

class InvestmentApplicationController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:investment-list', ['only' => ['index', 'withdrawals']]);
        $this->middleware('permission:investment-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:investment-approve', ['only' => ['approve', 'approveWithdrawal']]);
        $this->middleware('permission:investment-withdraw', ['only' => ['requestWithdrawal', 'storeWithdrawal']]);
    }

    public function index()
    {
        $apps = InvestmentApplication::with('member', 'partner')->paginate(25);
        return view('admin.investments.index', compact('apps'));
    }

    public function create()
    {
        $members = Member::all();
        $partners = Partner::all();
        return view('admin.investments.create', compact('members', 'partners'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'member_id' => 'required|exists:members,id',
            'partner_id' => 'required|exists:partners,id',
            'amount' => 'required|numeric|min:1',
            'purpose' => 'nullable|string'
        ]);

        InvestmentApplication::create([
            'member_id' => $request->member_id,
            'partner_id' => $request->partner_id,
            'amount' => $request->amount,
            'purpose' => $request->purpose,
            'status' => 'pending',
            'applied_at' => now()
        ]);

        return redirect()->route('investments.index')->with('success', 'Investment application submitted');
    }

    public function approve($id)
    {
        $app = InvestmentApplication::findOrFail($id);
        if ($app->status !== 'pending') {
            return back()->with('error', 'Application cannot be approved');
        }

        $companyFund = CompanyFund::firstOrCreate([], ['balance' => 0]);
        if ($companyFund->balance < $app->amount) {
            return back()->with('error', 'Insufficient company fund for this investment');
        }

        $app->update([
            'status' => 'approved',
            'approved_by' => auth()->id(),
            'approved_at' => now()
        ]);

        // Update company fund
        $companyFund->increment('balance', $app->amount);

        // Update partner invested amount
        $app->partner->increment('invested_amount', $app->amount);

        // Notify member
        $member = $app->member;
        if ($member) {
            \App\Services\NotificationService::send('investment_approved', [$member->email, $member->phone], ['email', 'sms'], 'Your investment application of ' . number_format($app->amount, 2) . ' has been approved.', ['investment_id' => $app->id]);
        }

        return back()->with('success', 'Investment approved and funds updated');
    }

    public function show(InvestmentApplication $investment)
    {
        return view('admin.investments.show', compact('investment'));
    }

    // Investment Withdrawal Methods
    public function withdrawals()
    {
        $withdrawals = InvestmentWithdrawalRequest::with('partner')->paginate(25);
        return view('admin.investments.withdrawals', compact('withdrawals'));
    }

    public function requestWithdrawal()
    {
        $partners = Partner::where('status', 'active')->get();
        return view('admin.investments.request_withdrawal', compact('partners'));
    }

    public function storeWithdrawal(Request $request)
    {
        $request->validate([
            'partner_id' => 'required|exists:partners,id',
            'amount' => 'required|numeric|min:1'
        ]);

        $partner = Partner::findOrFail($request->partner_id);

        // Check if partner has sufficient invested amount
        if ($request->amount > $partner->invested_amount) {
            return back()->with('error', 'Insufficient invested amount for this withdrawal');
        }

        InvestmentWithdrawalRequest::create([
            'partner_id' => $request->partner_id,
            'amount' => $request->amount,
            'status' => 'pending',
            'remarks' => $request->remarks,
            'requested_at' => now()
        ]);

        return redirect()->route('investments.withdrawals')->with('success', 'Investment withdrawal request submitted');
    }

    public function approveWithdrawal($id)
    {
        $withdrawal = InvestmentWithdrawalRequest::findOrFail($id);
        if ($withdrawal->status !== 'pending') {
            return back()->with('error', 'Withdrawal request cannot be approved');
        }

        $companyFund = CompanyFund::firstOrCreate([], ['balance' => 0]);
        if ($companyFund->balance < $withdrawal->amount) {
            return back()->with('error', 'Insufficient company fund for this withdrawal');
        }

        $withdrawal->update([
            'status' => 'approved',
            'approved_by' => auth()->id(),
            'approved_at' => now()
        ]);

        // Reduce company fund
        $companyFund->decrement('balance', $withdrawal->amount);

        // Reduce partner invested amount
        $withdrawal->partner->decrement('invested_amount', $withdrawal->amount);

        // Log cash transaction
        $cashAsset = CashAsset::first();
        if ($cashAsset) {
            CashTransaction::create([
                'cash_asset_id' => $cashAsset->id,
                'type' => 'outflow',
                'amount' => $withdrawal->amount,
                'reference_type' => 'investment_withdrawal',
                'reference_id' => $withdrawal->id,
                'remarks' => 'Investment withdrawal approved'
            ]);
            $cashAsset->decrement('balance', $withdrawal->amount);
        }

        // Notify partner
        $partner = $withdrawal->partner;
        if ($partner) {
            \App\Services\NotificationService::send('investment_withdrawal_approved', [$partner->email, $partner->phone], ['email', 'sms'], 'Your investment withdrawal of ' . number_format($withdrawal->amount, 2) . ' has been approved.', ['withdrawal_id' => $withdrawal->id]);
        }

        return back()->with('success', 'Investment withdrawal approved and funds disbursed');
    }
}
