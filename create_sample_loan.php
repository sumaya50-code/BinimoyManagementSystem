<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Member;
use App\Models\Loan;

$member = Member::first();
if ($member) {
    $loan = Loan::create([
        'member_id' => $member->id,
        'loan_amount' => 10000,
        'interest_rate' => 12,
        'installment_count' => 12,
        'installment_type' => 'monthly',
        'status' => 'active'
    ]);

    if ($loan) {
        echo "Sample loan created successfully! ID: {$loan->id}\n";
        echo "Member: {$member->name}\n";
        echo "Amount: {$loan->loan_amount}\n";
        echo "Status: {$loan->status}\n";
    } else {
        echo "Failed to create loan\n";
    }
} else {
    echo "No members found in database\n";
}
