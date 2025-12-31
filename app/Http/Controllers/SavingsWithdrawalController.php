<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;
use App\Models\SavingsAccount;
use App\Models\SavingsWithdrawalRequest;

class SavingsWithdrawalController extends Controller
{
    public function index() {
        $withdrawals = SavingsWithdrawalRequest::with('member')->get();
        return view('admin.withdrawals.index', compact('withdrawals'));
    }

    public function create() {
        $members = Member::all();
        return view('admin.withdrawals.create', compact('members'));
    }

    public function store(Request $request) {
        $request->validate([
            'member_id' => 'required|exists:members,id',
            'amount' => 'required|numeric|min:1',
        ]);

        SavingsWithdrawalRequest::create([
            'member_id'=>$request->member_id,
            'amount'=>$request->amount,
            'status'=>'pending'
        ]);

        return redirect()->route('withdrawals.index')->with('success','Withdrawal request submitted');
    }

    public function edit($id) {
        $withdrawal = SavingsWithdrawalRequest::findOrFail($id);
        return view('admin.withdrawals.edit', compact('withdrawal'));
    }

    public function update(Request $request, $id) {
        $withdrawal = SavingsWithdrawalRequest::findOrFail($id);
        $withdrawal->update($request->only('amount','status'));
        return redirect()->route('withdrawals.index')->with('success','Withdrawal updated');
    }

    public function destroy($id) {
        $withdrawal = SavingsWithdrawalRequest::findOrFail($id);
        $withdrawal->delete();
        return back()->with('success','Withdrawal request deleted');
    }

    // Admin Approval
    public function approveWithdrawal(SavingsWithdrawalRequest $withdrawal) {
        $account = SavingsAccount::where('member_id',$withdrawal->member_id)->first();
        if(!$account || $account->balance < $withdrawal->amount) {
            return back()->with('error','Insufficient balance');
        }

        $account->balance -= $withdrawal->amount; // Step: Balance reduced
        $account->save();

        $withdrawal->status = 'approved';
        $withdrawal->save();

        // Step: Company fund reduced and voucher can be generated here
        return back()->with('success','Withdrawal approved');
    }
}
