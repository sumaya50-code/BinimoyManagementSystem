<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\LoanInstallment;
use App\Models\Loan;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\LoanInstallment>
 */
class LoanInstallmentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = LoanInstallment::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'loan_id' => Loan::factory(),
            'installment_no' => $this->faker->numberBetween(1, 12),
            'due_date' => $this->faker->date(),
            'principal_amount' => $this->faker->randomFloat(2, 100, 1000),
            'interest_amount' => $this->faker->randomFloat(2, 10, 100),
            'amount' => $this->faker->randomFloat(2, 110, 1100),
            'paid_amount' => $this->faker->randomFloat(2, 0, 1100),
            'penalty_amount' => $this->faker->randomFloat(2, 0, 50),
            'status' => $this->faker->randomElement(['pending', 'paid', 'overdue']),
            'paid_at' => $this->faker->optional()->dateTime(),
        ];
    }
}
