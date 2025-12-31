<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\CashTransaction;
use App\Models\CashAsset;

echo "=== Testing Cash Flow Implementation ===\n";

// Check if CashAsset exists
$cashAsset = CashAsset::first();
if (!$cashAsset) {
    echo "No CashAsset found. Creating one...\n";
    $cashAsset = CashAsset::create([
        'type' => 'cash_in_hand',
        'name' => 'Main Cash Account',
        'balance' => 10000
    ]);
}

echo "CashAsset ID: {$cashAsset->id}, Balance: {$cashAsset->balance}\n";

// Check recent CashTransactions
$recentTxns = CashTransaction::latest()->take(5)->get();
echo "\nRecent CashTransactions:\n";
foreach ($recentTxns as $txn) {
    echo "- ID: {$txn->id}, Type: {$txn->type}, Amount: {$txn->amount}, Reference: {$txn->reference_type}, Balance: {$txn->cashAsset->balance}\n";
}

echo "\n=== Test Complete ===\n";
