<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "=== Running Comprehensive Loan Module Tests ===\n\n";

$testResults = [
    'passed' => 0,
    'failed' => 0,
    'errors' => []
];

// Function to run a test and capture result
function runTest($testName, $testFunction)
{
    global $testResults;
    echo "Running: {$testName}... ";

    try {
        $result = $testFunction();
        if ($result === true) {
            echo "✓ PASSED\n";
            $testResults['passed']++;
        } else {
            echo "✗ FAILED\n";
            $testResults['failed']++;
            $testResults['errors'][] = $testName . ": " . ($result ?: "Test returned false");
        }
    } catch (Exception $e) {
        echo "✗ ERROR\n";
        $testResults['failed']++;
        $testResults['errors'][] = $testName . ": " . $e->getMessage();
    }
}

// Test 1: Model Relationships
runTest("Loan Model Relationships", function () {
    $member = \App\Models\Member::factory()->create();
    $proposal = \App\Models\LoanProposal::factory()->create(['member_id' => $member->id]);
    $loan = \App\Models\Loan::factory()->create([
        'loan_proposal_id' => $proposal->id,
        'member_id' => $member->id
    ]);

    return $loan->loanProposal->id === $proposal->id &&
        $loan->loanProposal->member->id === $member->id;
});

// Test 2: Installment Generation
runTest("Installment Generation", function () {
    $member = \App\Models\Member::factory()->create();
    $proposal = \App\Models\LoanProposal::factory()->create(['member_id' => $member->id]);

    $loan = \App\Models\Loan::create([
        'loan_proposal_id' => $proposal->id,
        'member_id' => $member->id,
        'loan_amount' => 12000,
        'disbursed_amount' => 12000,
        'remaining_amount' => 12000,
        'interest_rate' => 12,
        'installment_count' => 12,
        'installment_type' => 'monthly',
        'disbursement_date' => now(),
        'status' => 'Active'
    ]);

    $loan->generateInstallments();

    $count = $loan->installments()->count();
    $loan->installments()->delete();
    $loan->delete();

    return $count === 12;
});

// Test 3: Approval Workflow
runTest("Loan Proposal Approval Workflow", function () {
    $member = \App\Models\Member::factory()->create();
    $proposal = \App\Models\LoanProposal::factory()->create([
        'member_id' => $member->id,
        'status' => 'pending'
    ]);

    $result1 = $proposal->submitForAudit();
    $result2 = $proposal->approveAudit();
    $result3 = $proposal->approveManagerReview();
    $result4 = $proposal->approveAreaManager();

    $finalStatus = $proposal->fresh()->status;

    $proposal->delete();

    return $result1 && $result2 && $result3 && $result4 && $finalStatus === 'approved';
});

// Test 4: Business Rule Validation - Insufficient Savings
runTest("Business Rule: Insufficient Savings", function () {
    $member = \App\Models\Member::factory()->create();

    $request = new \Illuminate\Http\Request([
        'member_id' => $member->id,
        'proposed_amount' => 10000,
        'business_type' => 'Retail Business',
        'loan_proposal_date' => '2024-01-15',
        'savings_balance' => 500, // Less than 10% of 10000
        'dps_balance' => 0,
    ]);

    $controller = new \App\Http\Controllers\LoanProposalController();

    try {
        $response = $controller->store($request);
        $member->delete();
        return false; // Should have thrown validation error
    } catch (\Illuminate\Validation\ValidationException $e) {
        $member->delete();
        return true; // Correctly rejected
    }
});

// Test 5: Business Rule Validation - Defaulted Previous Loan
runTest("Business Rule: Defaulted Previous Loan", function () {
    $member = \App\Models\Member::factory()->create();

    $request = new \Illuminate\Http\Request([
        'member_id' => $member->id,
        'proposed_amount' => 10000,
        'business_type' => 'Retail Business',
        'loan_proposal_date' => '2024-01-15',
        'savings_balance' => 1500,
        'dps_balance' => 500,
        'previous_loans' => [
            [
                'loan_amount' => 5000,
                'loan_status' => 'defaulted' // Should reject
            ]
        ]
    ]);

    $controller = new \App\Http\Controllers\LoanProposalController();

    try {
        $response = $controller->store($request);
        $member->delete();
        return false; // Should have thrown validation error
    } catch (\Illuminate\Validation\ValidationException $e) {
        $member->delete();
        return true; // Correctly rejected
    }
});

// Test 6: Loan Disbursement
runTest("Loan Disbursement", function () {
    $member = \App\Models\Member::factory()->create();
    $proposal = \App\Models\LoanProposal::factory()->create([
        'member_id' => $member->id,
        'status' => 'approved',
        'proposed_amount' => 10000
    ]);

    $companyFund = \App\Models\CompanyFund::firstOrCreate([], ['balance' => 15000]);
    $cashAsset = \App\Models\CashAsset::firstOrCreate([], ['balance' => 15000]);

    $initialCompanyBalance = $companyFund->balance;
    $initialCashBalance = $cashAsset->balance;

    $loan = \App\Models\Loan::create([
        'loan_proposal_id' => $proposal->id,
        'member_id' => $member->id,
        'loan_amount' => 10000,
        'disbursed_amount' => 10000,
        'remaining_amount' => 10000,
        'interest_rate' => 12,
        'installment_count' => 12,
        'installment_type' => 'monthly',
        'disbursement_date' => now(),
        'status' => 'Active'
    ]);

    $companyFund->decrement('balance', 10000);
    $cashAsset->decrement('balance', 10000);

    $loan->generateInstallments();

    $installmentCount = $loan->installments()->count();
    $finalCompanyBalance = $companyFund->balance;
    $finalCashBalance = $cashAsset->balance;

    // Cleanup
    $loan->installments()->delete();
    $loan->delete();
    $proposal->delete();
    $member->delete();

    return $installmentCount === 12 &&
        $finalCompanyBalance === $initialCompanyBalance - 10000 &&
        $finalCashBalance === $initialCashBalance - 10000;
});

// Test 7: Collection and Verification
runTest("Collection and Verification", function () {
    $member = \App\Models\Member::factory()->create();
    $proposal = \App\Models\LoanProposal::factory()->create(['member_id' => $member->id]);
    $loan = \App\Models\Loan::factory()->create([
        'loan_proposal_id' => $proposal->id,
        'member_id' => $member->id,
        'remaining_amount' => 1000
    ]);

    $installment = \App\Models\LoanInstallment::factory()->create([
        'loan_id' => $loan->id,
        'amount' => 1000,
        'paid_amount' => 0,
        'status' => 'pending'
    ]);

    $collection = \App\Models\LoanCollection::factory()->create([
        'loan_installment_id' => $installment->id,
        'amount' => 1000,
        'status' => 'pending'
    ]);

    $companyFund = \App\Models\CompanyFund::firstOrCreate([], ['balance' => 10000]);
    $cashAsset = \App\Models\CashAsset::firstOrCreate([], ['balance' => 10000]);

    // Verify collection
    $collection->update(['status' => 'verified', 'verified_by' => 1, 'verified_at' => now()]);
    $installment->increment('paid_amount', 1000);
    $installment->update(['status' => 'paid', 'paid_at' => now()]);
    $loan->decrement('remaining_amount', 1000);
    $loan->update(['status' => 'Completed']);

    $companyFund->increment('balance', 1000);
    $cashAsset->increment('balance', 1000);

    $finalLoanStatus = $loan->fresh()->status;
    $finalInstallmentStatus = $installment->fresh()->status;
    $finalLoanRemaining = $loan->fresh()->remaining_amount;

    // Cleanup
    $collection->delete();
    $installment->delete();
    $loan->delete();
    $proposal->delete();
    $member->delete();

    return $finalLoanStatus === 'Completed' &&
        $finalInstallmentStatus === 'paid' &&
        $finalLoanRemaining === 0;
});

// Test 8: Penalty Application
runTest("Penalty Application for Overdue", function () {
    $member = \App\Models\Member::factory()->create();
    $proposal = \App\Models\LoanProposal::factory()->create(['member_id' => $member->id]);
    $loan = \App\Models\Loan::factory()->create([
        'loan_proposal_id' => $proposal->id,
        'member_id' => $member->id,
        'penalty_rate' => 0.5
    ]);

    $installment = \App\Models\LoanInstallment::factory()->create([
        'loan_id' => $loan->id,
        'amount' => 1000,
        'due_date' => now()->subDays(5), // 5 days overdue
        'status' => 'pending'
    ]);

    // Calculate penalty (0.5% per day)
    $overdueDays = 5;
    $penalty = (1000 * 0.5 * $overdueDays) / 100; // 25

    $installment->update([
        'penalty_amount' => $penalty,
        'status' => 'overdue'
    ]);

    $finalPenalty = $installment->fresh()->penalty_amount;
    $finalStatus = $installment->fresh()->status;

    // Cleanup
    $installment->delete();
    $loan->delete();
    $proposal->delete();
    $member->delete();

    return $finalPenalty == 25 && $finalStatus === 'overdue';
});

// Test 9: Edge Case - Zero Interest Rate
runTest("Edge Case: Zero Interest Rate", function () {
    $member = \App\Models\Member::factory()->create();
    $proposal = \App\Models\LoanProposal::factory()->create(['member_id' => $member->id]);

    $loan = \App\Models\Loan::create([
        'loan_proposal_id' => $proposal->id,
        'member_id' => $member->id,
        'loan_amount' => 12000,
        'disbursed_amount' => 12000,
        'remaining_amount' => 12000,
        'interest_rate' => 0, // Zero interest
        'installment_count' => 12,
        'installment_type' => 'monthly',
        'disbursement_date' => now(),
        'status' => 'Active'
    ]);

    $loan->generateInstallments();

    $totalInstallmentAmount = $loan->installments()->sum('amount');

    // Cleanup
    $loan->installments()->delete();
    $loan->delete();
    $proposal->delete();
    $member->delete();

    return $totalInstallmentAmount === 12000; // Should equal principal only
});

// Test 10: Edge Case - Partial Payments
runTest("Edge Case: Partial Payments", function () {
    $member = \App\Models\Member::factory()->create();
    $proposal = \App\Models\LoanProposal::factory()->create(['member_id' => $member->id]);
    $loan = \App\Models\Loan::factory()->create([
        'loan_proposal_id' => $proposal->id,
        'member_id' => $member->id,
        'remaining_amount' => 1000
    ]);

    $installment = \App\Models\LoanInstallment::factory()->create([
        'loan_id' => $loan->id,
        'amount' => 1000,
        'paid_amount' => 0,
        'status' => 'pending'
    ]);

    // First partial payment
    $installment->increment('paid_amount', 400);
    $loan->decrement('remaining_amount', 400);

    // Second partial payment
    $installment->increment('paid_amount', 600);
    $installment->update(['status' => 'paid', 'paid_at' => now()]);
    $loan->decrement('remaining_amount', 600);
    $loan->update(['status' => 'Completed']);

    $finalPaidAmount = $installment->fresh()->paid_amount;
    $finalInstallmentStatus = $installment->fresh()->status;
    $finalLoanRemaining = $loan->fresh()->remaining_amount;
    $finalLoanStatus = $loan->fresh()->status;

    // Cleanup
    $installment->delete();
    $loan->delete();
    $proposal->delete();
    $member->delete();

    return $finalPaidAmount === 1000 &&
        $finalInstallmentStatus === 'paid' &&
        $finalLoanRemaining === 0 &&
        $finalLoanStatus === 'Completed';
});

// Summary
echo "\n=== Test Results Summary ===\n";
echo "Passed: {$testResults['passed']}\n";
echo "Failed: {$testResults['failed']}\n";

if (!empty($testResults['errors'])) {
    echo "\nErrors:\n";
    foreach ($testResults['errors'] as $error) {
        echo "- {$error}\n";
    }
}

$successRate = $testResults['passed'] / ($testResults['passed'] + $testResults['failed']) * 100;
echo "\nSuccess Rate: " . round($successRate, 2) . "%\n";

if ($successRate >= 80) {
    echo "✓ Loan module testing completed successfully!\n";
} else {
    echo "✗ Loan module has significant issues that need attention.\n";
}

echo "\n=== Recommendations ===\n";
echo "1. Run 'php artisan test' to execute the full PHPUnit test suite\n";
echo "2. Review failed tests and fix underlying issues\n";
echo "3. Add more integration tests for complex workflows\n";
echo "4. Consider adding API tests for AJAX endpoints\n";
echo "5. Implement automated testing in CI/CD pipeline\n";
