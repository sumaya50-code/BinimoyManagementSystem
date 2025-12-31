<?php

require_once 'vendor/autoload.php';

use Illuminate\Foundation\Application;
use Illuminate\Contracts\Console\Kernel;
use Illuminate\Http\Request;

$app = require_once 'bootstrap/app.php';
$app->make(Kernel::class)->bootstrap();

echo "=== TESTING APPROVE AUDIT ENDPOINT ===\n\n";

// Simulate authenticated user
$user = \App\Models\User::find(1); // Admin user
\Auth::login($user);

echo "✓ Logged in as user: {$user->name} (ID: {$user->id})\n";

// Get the loan proposal
$proposal = \App\Models\LoanProposal::find(1);
if (!$proposal) {
    echo "✗ Loan proposal with ID 1 not found\n";
    exit;
}

echo "✓ Found loan proposal with status: {$proposal->status}\n";

// Test the approveAudit method directly
$controller = new \App\Http\Controllers\LoanProposalController();
$request = new Request();

try {
    $response = $controller->approveAudit($request, $proposal);
    echo "✓ approveAudit method executed successfully\n";

    // Check if status changed
    $proposal->refresh();
    echo "✓ Proposal status after approval: {$proposal->status}\n";
} catch (Exception $e) {
    echo "✗ Error in approveAudit: " . $e->getMessage() . "\n";
}

echo "\n=== TEST COMPLETED ===\n";
