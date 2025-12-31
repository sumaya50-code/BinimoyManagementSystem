<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Member;
use App\Models\SavingsAccount;
use App\Models\SavingsTransaction;
use App\Models\SavingsWithdrawalRequest;
use App\Models\CompanyFund;

// Test Deposit Flow
echo "=== Testing Deposit Flow ===\n";

$member = Member::first();
if (!$member) {
    echo "No members found. Please seed the database.\n";
    exit;
}

$account = SavingsAccount::where('member_id', $member->id)->first();
if (!$account) {
    $account = SavingsAccount::create([
        'member_id' => $member->id,
        'balance' => 0,
        'interest_rate' => 5
    ]);
}

echo "Member: {$member->name}, Account: {$account->account_no}, Initial Balance: {$account->balance}\n";

// 1. Deposit Entry (Pending)
$txn = SavingsTransaction::create([
    'savings_account_id' => $account->id,
    'type' => 'deposit',
    'amount' => 1000,
    'remarks' => 'Test Deposit',
    'status' => 'pending',
    'transaction_date' => now()
]);

echo "Deposit Entry: ID {$txn->id}, Status: {$txn->status}, Amount: {$txn->amount}\n";

// 2. Approve Deposit (Admin Approval)
$txn->update(['status' => 'approved']);
$account->increment('balance', $txn->amount);

// Update company fund balance
$companyFund = CompanyFund::firstOrCreate([], ['balance' => 0]);
$companyFund->increment('balance', $txn->amount);

echo "After Approval: Account Balance: {$account->fresh()->balance}, Company Fund: {$companyFund->fresh()->balance}\n";

// 3. Interest Calculation
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

echo "After Interest: Account Balance: {$account->fresh()->balance}, Interest Added: {$interest}\n";

// Test Withdrawal Flow
echo "\n=== Testing Withdrawal Flow ===\n";

$companyFund = CompanyFund::firstOrCreate([], ['balance' => 5000]); // Ensure company has cash
echo "Company Fund Balance: {$companyFund->balance}\n";

// 1. Withdrawal Request
$withdrawal = SavingsWithdrawalRequest::create([
    'member_id' => $member->id,
    'amount' => 500,
    'status' => 'pending'
]);

echo "Withdrawal Request: ID {$withdrawal->id}, Status: {$withdrawal->status}, Amount: {$withdrawal->amount}\n";

// 2. Approve Withdrawal
if ($withdrawal->amount <= $account->balance && $companyFund->balance >= $withdrawal->amount) {
    $withdrawal->update([
        'status' => 'approved',
        'approved_by' => 1, // Assuming admin ID 1
        'approved_at' => now()
    ]);

    $account->decrement('balance', $withdrawal->amount);
    $companyFund->decrement('balance', $withdrawal->amount);

    SavingsTransaction::create([
        'savings_account_id' => $account->id,
        'type' => 'withdrawal',
        'amount' => $withdrawal->amount,
        'transaction_date' => now(),
        'remarks' => 'Savings Withdrawal',
        'status' => 'approved'
    ]);

    echo "After Withdrawal Approval: Account Balance: {$account->fresh()->balance}, Company Fund: {$companyFund->fresh()->balance}\n";
} else {
    echo "Insufficient balance for withdrawal\n";
}

echo "\n=== Test Complete ===\n";
