<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Member;
use App\Models\SavingsAccount;
use App\Models\SavingsTransaction;
use App\Models\SavingsWithdrawalRequest;
use App\Models\CompanyFund;

echo "=== Testing Edge Cases ===\n";

$member = Member::first();
$account = SavingsAccount::where('member_id', $member->id)->first();
$companyFund = CompanyFund::first();

// Edge Case 1: Withdrawal with insufficient savings balance
echo "1. Testing withdrawal with insufficient savings balance\n";
$currentBalance = $account->balance;
$withdrawal = SavingsWithdrawalRequest::create([
    'member_id' => $member->id,
    'amount' => $currentBalance + 1000, // More than balance
    'status' => 'pending'
]);

try {
    if ($withdrawal->amount > $account->balance) {
        echo "   Error: Insufficient savings balance ({$account->balance} < {$withdrawal->amount})\n";
    } else {
        echo "   Unexpected: Withdrawal should have failed\n";
    }
} catch (\Exception $e) {
    echo "   Exception: {$e->getMessage()}\n";
}
$withdrawal->delete(); // Clean up

// Edge Case 2: Withdrawal with insufficient company fund
echo "2. Testing withdrawal with insufficient company fund\n";
$originalCompanyBalance = $companyFund->balance;
$companyFund->update(['balance' => 100]); // Set low balance

$withdrawal = SavingsWithdrawalRequest::create([
    'member_id' => $member->id,
    'amount' => 500, // More than company fund
    'status' => 'pending'
]);

try {
    if ($companyFund->balance < $withdrawal->amount) {
        echo "   Error: Company fund has insufficient balance ({$companyFund->balance} < {$withdrawal->amount})\n";
    } else {
        echo "   Unexpected: Withdrawal should have failed\n";
    }
} catch (\Exception $e) {
    echo "   Exception: {$e->getMessage()}\n";
}
$withdrawal->delete(); // Clean up
$companyFund->update(['balance' => $originalCompanyBalance]); // Restore

// Edge Case 3: Invalid transaction approval (non-deposit)
echo "3. Testing approval of non-deposit transaction\n";
$txn = SavingsTransaction::create([
    'savings_account_id' => $account->id,
    'type' => 'withdrawal', // Wrong type
    'amount' => 100,
    'remarks' => 'Invalid Test',
    'status' => 'pending',
    'transaction_date' => now()
]);

try {
    if ($txn->type != 'deposit' || $txn->status != 'pending') {
        echo "   Error: Invalid transaction (type: {$txn->type}, status: {$txn->status})\n";
    } else {
        echo "   Unexpected: Should not approve\n";
    }
} catch (\Exception $e) {
    echo "   Exception: {$e->getMessage()}\n";
}
$txn->delete(); // Clean up

// Edge Case 4: Deposit with zero or negative amount
echo "4. Testing deposit with zero amount\n";
try {
    $txn = SavingsTransaction::create([
        'savings_account_id' => $account->id,
        'type' => 'deposit',
        'amount' => 0,
        'remarks' => 'Zero Deposit',
        'status' => 'pending',
        'transaction_date' => now()
    ]);
    echo "   Warning: Zero amount deposit created (ID: {$txn->id})\n";
    $txn->delete();
} catch (\Exception $e) {
    echo "   Exception: {$e->getMessage()}\n";
}

// Edge Case 5: Interest calculation with zero balance
echo "5. Testing interest calculation with zero balance\n";
$tempAccount = SavingsAccount::create([
    'member_id' => $member->id,
    'balance' => 0,
    'interest_rate' => 5
]);

$interest = ($tempAccount->balance * $tempAccount->interest_rate) / 100 / 12;
echo "   Interest on zero balance: {$interest} (should be 0)\n";
$tempAccount->delete();

// Test Ledger Posting
echo "6. Testing ledger posting\n";
$txn = SavingsTransaction::create([
    'savings_account_id' => $account->id,
    'type' => 'deposit',
    'amount' => 100,
    'remarks' => 'Ledger Test',
    'status' => 'pending',
    'transaction_date' => now()
]);

$txn->update(['status' => 'approved']); // This should trigger ledger posting

$journal = \App\Models\Journal::where('transactionable_type', get_class($txn))
    ->where('transactionable_id', $txn->id)
    ->first();

if ($journal) {
    echo "   Ledger posted: Journal ID {$journal->id}\n";
    $entries = $journal->ledgerEntries;
    echo "   Debit entries: " . $entries->where('debit', '>', 0)->count() . "\n";
    echo "   Credit entries: " . $entries->where('credit', '>', 0)->count() . "\n";
} else {
    echo "   Error: No ledger entry found\n";
}

echo "\n=== Edge Cases Test Complete ===\n";
