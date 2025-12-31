<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\LoanProposal;
use App\Models\Member;
use Illuminate\Http\Request;

echo "Testing Loan Proposal Store Method\n";
echo "===================================\n\n";

// Find or create a test member
$member = Member::first();
if (!$member) {
    echo "No members found. Creating a test member...\n";
    $member = Member::create([
        'name' => 'Test Member',
        'phone' => '1234567890',
        'guardian_name' => 'Test Guardian',
        'present_address' => 'Test Address',
        'member_no' => 'M001',
        'admission_date' => now(),
    ]);
    echo "Created test member ID: {$member->id}\n";
}

echo "Using member ID: {$member->id}\n\n";

// Create a test request with all required fields
$requestData = [
    'member_id' => $member->id,
    'proposed_amount' => 10000,
    'business_type' => 'Test Business',
    'loan_proposal_date' => now()->format('Y-m-d'),
    'savings_balance' => 2000, // 20% of proposed amount, should pass minimum check
    'dps_balance' => 0,
    'applicant_signature' => 'Test Applicant',
    'employee_signature' => 'Test Employee',
];

echo "Submitting request with data:\n";
print_r($requestData);
echo "\n";

$request = new Request($requestData);

try {
    // Call the controller method
    $controller = new \App\Http\Controllers\LoanProposalController();
    $response = $controller->store($request);

    echo "SUCCESS: Store method executed\n";

    // Check if proposal was created
    $latestProposal = LoanProposal::latest()->first();
    if ($latestProposal && $latestProposal->member_id == $member->id) {
        echo "Proposal created successfully! ID: {$latestProposal->id}\n";
        echo "Status: {$latestProposal->status}\n";
        echo "Proposed Amount: {$latestProposal->proposed_amount}\n";
    } else {
        echo "Proposal was not created or not found\n";
    }
} catch (\Illuminate\Validation\ValidationException $e) {
    echo "VALIDATION ERROR:\n";
    print_r($e->errors());
} catch (Throwable $e) {
    echo "ERROR: {$e->getMessage()}\n";
    echo "Type: " . get_class($e) . "\n";
    echo "File: {$e->getFile()}:{$e->getLine()}\n";
}

echo "\nTest completed.\n";
