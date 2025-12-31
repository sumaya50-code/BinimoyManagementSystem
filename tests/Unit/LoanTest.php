<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Loan;
use App\Models\LoanInstallment;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LoanTest extends TestCase
{
    use RefreshDatabase;

    public function test_check_completion_marks_loan_completed_when_all_installments_paid()
    {
        $loan = Loan::factory()->create(['status' => 'active']);
        $installment1 = LoanInstallment::factory()->create(['loan_id' => $loan->id, 'status' => 'paid']);
        $installment2 = LoanInstallment::factory()->create(['loan_id' => $loan->id, 'status' => 'paid']);

        $loan->checkCompletion();

        $loan->refresh();
        $this->assertEquals('completed', $loan->status);
    }

    public function test_check_completion_does_not_mark_completed_when_some_installments_pending()
    {
        $loan = Loan::factory()->create(['status' => 'active']);
        $installment1 = LoanInstallment::factory()->create(['loan_id' => $loan->id, 'status' => 'paid']);
        $installment2 = LoanInstallment::factory()->create(['loan_id' => $loan->id, 'status' => 'pending']);

        $loan->checkCompletion();

        $loan->refresh();
        $this->assertEquals('active', $loan->status);
    }
}
