<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Member;
use App\Models\LoanProposal;
use App\Models\PreviousLoan;
use App\Models\SavingsAccount;
use Illuminate\Http\Request;

echo "=== Testing Another Loan Proposal Form Input Storage ===\n";

$member = Member::first();
if (!$member) {
    echo "No member found. Creating a test member...\n";
    $member = Member::create([
        'name' => 'Test Member 2',
        'phone' => '0987654321',
        'member_no' => 'TEST002',
        'guardian_name' => 'Test Guardian 2',
        'present_address' => 'Test Address 2',
        'business_type' => 'Wholesale',
        'admission_date' => now(),
    ]);
    echo "✓ Test member created (ID: {$member->id})\n";
}

// Create savings account for the member
$savingsAccount = SavingsAccount::where('member_id', $member->id)->first();
if (!$savingsAccount) {
    $savingsAccount = SavingsAccount::create([
        'member_id' => $member->id,
        'account_no' => 'SAV' . str_pad($member->id, 4, '0', STR_PAD_LEFT),
        'balance' => 2000.00, // Set a test balance
    ]);
    echo "✓ Savings account created with balance: {$savingsAccount->balance}\n";
}

// Test form submission with previous loan information
echo "\nTesting form submission with previous loan details\n";

$formData = [
    'member_id' => $member->id,
    'proposed_amount' => 15000.00,
    'business_type' => 'Wholesale Business',
    'loan_proposal_date' => '2024-02-01',
    'savings_balance' => $savingsAccount->balance,
    'dps_balance' => 1000.00,
    'guarantor_name' => 'Another Guarantor',
    'guarantor_guardian_name' => 'Another Guardian',
    'guarantor_address' => 'Another Address',
    'applicant_signature' => 'Jane Doe Signature',
    'employee_signature' => 'Employee Signature 2',
    'audited_verified' => 'Auditor Name 2',
    'approved_amount_audit' => 14000.00,
    'auditor_signature' => 'Auditor Signature 2',
    'verified_by_manager' => 'Manager Name 2',
    'approved_amount_manager' => 13500.00,
    'manager_signature' => 'Manager Signature 2',
    'verified_by_area_manager' => 'Area Manager Name 2',
    'approved_amount_area' => 13000.00,
    'date_approved' => '2024-02-05',
    'authorized_signatory_signature' => 'Authorized Signature 2',
    'previous_loans' => []
];

$request = new Request($formData);

// Simulate the store method
try {
    $controller = new \App\Http\Controllers\LoanProposalController();
    $response = $controller->store($request);

    // Check if proposal was created
    $proposal = LoanProposal::where('member_id', $member->id)
        ->where('proposed_amount', 15000.00)
        ->latest()
        ->first();

    if ($proposal) {
        echo "✓ Loan proposal created (ID: {$proposal->id})\n";

        // Test previous loans storage
        echo "\nTesting previous loans storage\n";
        $previousLoans = PreviousLoan::where('loan_proposal_id', $proposal->id)->get();

        if ($previousLoans->count() == 0) {
            echo "✓ No previous loans recorded (Count: {$previousLoans->count()})\n";
            echo "✓ This matches the 'No previous loans recorded' scenario\n";
        } else {
            echo "✗ Unexpected previous loans found. Expected: 0, Got: {$previousLoans->count()}\n";
        }

        // Cleanup
        $previousLoans->each->delete();
        $proposal->delete();
    } else {
        echo "✗ Loan proposal not created\n";
    }
} catch (\Exception $e) {
    echo "✗ Error during form submission: " . $e->getMessage() . "\n";
}

// Cleanup test data
if (isset($savingsAccount)) {
    $savingsAccount->delete();
}
if ($member->member_no === 'TEST002') {
    $member->delete();
}

echo "\n=== Another Loan Proposal Test Complete ===\n";
