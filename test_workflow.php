<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\LoanProposal;

echo "Testing Loan Proposal Workflow\n";
echo "==============================\n\n";

// Find a pending proposal
$proposal = LoanProposal::where('status', 'pending')->first();

if (!$proposal) {
    echo "No pending proposals found. Creating a test proposal...\n";

    // Create a test member first
    $member = \App\Models\Member::first();
    if (!$member) {
        echo "No members found. Please create a member first.\n";
        exit(1);
    }

    $proposal = LoanProposal::create([
        'member_id' => $member->id,
        'proposed_amount' => 10000,
        'status' => 'pending',
        'business_type' => 'Test Business',
        'loan_proposal_date' => now(),
        'savings_balance' => 2000,
        'dps_balance' => 0,
    ]);

    echo "Created test proposal ID: {$proposal->id}\n";
}

echo "Found pending proposal ID: {$proposal->id}\n";
echo "Current status: {$proposal->status}\n";

// Test submit for audit
echo "\nTesting submitForAudit...\n";
$result = $proposal->submitForAudit();
echo "Submit result: " . ($result ? 'SUCCESS' : 'FAILED') . "\n";

$proposal->refresh();
echo "New status: {$proposal->status}\n";
echo "Submitted at: " . ($proposal->submitted_at ?? 'NULL') . "\n";

// Test approve audit
if ($proposal->status === 'under_audit') {
    echo "\nTesting approveAudit...\n";
    $result = $proposal->approveAudit();
    echo "Approve audit result: " . ($result ? 'SUCCESS' : 'FAILED') . "\n";

    $proposal->refresh();
    echo "New status: {$proposal->status}\n";
    echo "Audited at: " . ($proposal->audited_at ?? 'NULL') . "\n";
}

echo "\nWorkflow test completed.\n";
