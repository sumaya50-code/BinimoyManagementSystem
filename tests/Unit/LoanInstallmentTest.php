<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Loan;
use App\Models\LoanInstallment;
use App\Models\LoanCollection;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LoanInstallmentTest extends TestCase
{
    use RefreshDatabase;

    public function test_collect_payment_marks_installment_paid_when_full_amount_collected()
    {
        $loan = Loan::factory()->create();
        $installment = LoanInstallment::factory()->create([
            'loan_id' => $loan->id,
            'amount' => 100,
            'paid_amount' => 0,
            'status' => 'pending'
        ]);

        $installment->collect(100);

        $installment->refresh();
        $this->assertEquals('paid', $installment->status);
        $this->assertEquals(100, $installment->paid_amount);
        $this->assertNotNull($installment->paid_at);
        $this->assertCount(1, $installment->collections);
    }

    public function test_collect_payment_does_not_mark_paid_when_partial_amount()
    {
        $loan = Loan::factory()->create();
        $installment = LoanInstallment::factory()->create([
            'loan_id' => $loan->id,
            'amount' => 100,
            'paid_amount' => 0,
            'status' => 'pending'
        ]);

        $installment->collect(50);

        $installment->refresh();
        $this->assertEquals('pending', $installment->status);
        $this->assertEquals(50, $installment->paid_amount);
        $this->assertNull($installment->paid_at);
    }

    public function test_collect_payment_creates_collection_record()
    {
        $loan = Loan::factory()->create();
        $installment = LoanInstallment::factory()->create([
            'loan_id' => $loan->id,
            'amount' => 100,
            'paid_amount' => 0,
            'status' => 'pending'
        ]);

        $installment->collect(50, 1, '2023-01-01', 'Test payment');

        $collection = $installment->collections()->first();
        $this->assertNotNull($collection);
        $this->assertEquals(50, $collection->amount);
        $this->assertEquals(1, $collection->collector_id);
        $this->assertEquals('2023-01-01', $collection->transaction_date);
        $this->assertEquals('Test payment', $collection->remarks);
    }
}
