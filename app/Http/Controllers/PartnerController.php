<?php

namespace App\Http\Controllers;

use App\Models\Partner;
use App\Models\PartnerWithdrawalRequest;
use App\Models\CompanyFund;
use App\Models\CashAsset;
use App\Models\CashTransaction;
use Illuminate\Http\Request;


class PartnerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $partners = \App\Models\Partner::all();
        return view('admin.partners.index', compact('partners'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.partners.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'share_percentage' => 'nullable|numeric',
            'invested_amount' => 'nullable|numeric'
        ]);

        \App\Models\Partner::create($request->all());
        return redirect()->route('partners.index')->with('success', 'Partner created');
    }

    /**
     * Display the specified resource.
     */
    public function show(Partner $partner)
    {
        return view('admin.partners.show', compact('partner'));
    }

    // Partner Withdrawal Methods
    public function withdrawals()
    {
        $withdrawals = PartnerWithdrawalRequest::with('partner')->paginate(25);
        return view('admin.partners.withdrawals', compact('withdrawals'));
    }

    public function requestWithdrawal()
    {
        $partners = Partner::where('status', 'active')->get();
        return view('admin.partners.request_withdrawal', compact('partners'));
    }

    public function storeWithdrawal(Request $request)
    {
        $request->validate([
            'partner_id' => 'required|exists:partners,id',
            'amount' => 'required|numeric|min:1',
            'type' => 'required|in:profit,capital'
        ]);

        $partner = Partner::findOrFail($request->partner_id);

        // Check if partner has sufficient amount based on type
        if ($request->type === 'profit') {
            if ($request->amount > $partner->total_profits) {
                return back()->with('error', 'Insufficient profit balance for this withdrawal');
            }
        } else { // capital
            if ($request->amount > $partner->invested_amount) {
                return back()->with('error', 'Insufficient invested capital for this withdrawal');
            }
        }

        PartnerWithdrawalRequest::create([
            'partner_id' => $request->partner_id,
            'amount' => $request->amount,
            'type' => $request->type,
            'status' => 'pending',
            'remarks' => $request->remarks,
            'requested_at' => now()
        ]);

        return redirect()->route('partners.withdrawals')->with('success', 'Partner withdrawal request submitted');
    }

    public function approveWithdrawal($id)
    {
        $withdrawal = PartnerWithdrawalRequest::findOrFail($id);
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

        // Reduce partner amount based on type
        if ($withdrawal->type === 'profit') {
            $withdrawal->partner->decrement('total_profits', $withdrawal->amount);
        } else { // capital
            $withdrawal->partner->decrement('invested_amount', $withdrawal->amount);
        }

        // Log cash transaction
        $cashAsset = CashAsset::first();
        if ($cashAsset) {
            CashTransaction::create([
                'cash_asset_id' => $cashAsset->id,
                'type' => 'outflow',
                'amount' => $withdrawal->amount,
                'reference_type' => 'partner_withdrawal',
                'reference_id' => $withdrawal->id,
                'remarks' => 'Partner withdrawal approved'
            ]);
            $cashAsset->decrement('balance', $withdrawal->amount);
        }

        // Notify partner
        $partner = $withdrawal->partner;
        if ($partner) {
            \App\Services\NotificationService::send('partner_withdrawal_approved', [$partner->email, $partner->phone], ['email', 'sms'], 'Your withdrawal of ' . number_format($withdrawal->amount, 2) . ' has been approved.', ['withdrawal_id' => $withdrawal->id]);
        }

        return back()->with('success', 'Partner withdrawal approved and funds disbursed');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Partner $partner)
    {
        return view('admin.partners.edit', compact('partner'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Partner $partner)
    {
        $request->validate([
            'name' => 'required|string',
            'share_percentage' => 'nullable|numeric',
            'invested_amount' => 'nullable|numeric'
        ]);
        $partner->update($request->all());
        return redirect()->route('partners.index')->with('success', 'Partner updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Partner $partner)
    {
        $partner->delete();
        return redirect()->route('partners.index')->with('success', 'Partner deleted');
    }
}
