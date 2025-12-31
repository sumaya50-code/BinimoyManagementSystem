<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\LoanProposal;
use App\Models\Member;
use Illuminate\Http\Request;

echo "Testing approveAreaManager fix for TypeError\n";
echo "===========================================\n\n";

// Find or create a test proposal in area_manager_approval status
$proposal = LoanProposal::where('status', 'area_manager_approval')->first();

if (!$proposal) {
    echo "No proposal in area_manager_approval status. Creating one...\n";

    $member = Member::first();
    if (!$member) {
        echo "No members found. Please create a member first.\n";
        exit(1);
    }

    $proposal = LoanProposal::create([
        'member_id' => $member->id,
        'proposed_amount' => 10000,
        'approved_amount_manager' => 8000,
        'approved_amount_area' => null, // This is null, which was causing the error
        'status' => 'area_manager_approval',
        'business_type' => 'Test Business',
        'loan_proposal_date' => now(),
        'savings_balance' => 2000,
        'dps_balance' => 0,
    ]);

    // Also test with a proposal that has null approved_amount_area
    echo "Also testing with approved_amount_area set to null...\n";
    $proposal->approved_amount_area = null;
    $proposal->save();

    echo "Created test proposal ID: {$proposal->id} with approved_amount_area = null\n";
}

echo "Testing proposal ID: {$proposal->id}\n";
echo "approved_amount_area: " . ($proposal->approved_amount_area ?? 'NULL') . "\n";
echo "approved_amount_manager: " . ($proposal->approved_amount_manager ?? 'NULL') . "\n";
echo "proposed_amount: {$proposal->proposed_amount}\n\n";

// Create a mock request for approveAreaManager
$requestData = [
    'disbursed_amount' => 5000, // Should be <= maxAmount (8000 from manager)
    'installment_count' => 10,
    'installment_type' => 'monthly',
    'interest_rate' => 5.0
];

$request = new Request($requestData);

echo "Testing approveAreaManager with disbursed_amount = {$requestData['disbursed_amount']}\n";

try {
    // Call the controller method
    $controller = new \App\Http\Controllers\LoanProposalController();
    $response = $controller->approveAreaManager($request, $proposal);

    echo "SUCCESS: No TypeError thrown!\n";
    echo "Response: " . (is_string($response) ? $response : 'Redirect response') . "\n";

    // Refresh and check status
    $proposal->refresh();
    echo "New status: {$proposal->status}\n";
} catch (Throwable $e) {
    echo "ERROR: {$e->getMessage()}\n";
    echo "Type: " . get_class($e) . "\n";
}

echo "\nTest completed.\n";
