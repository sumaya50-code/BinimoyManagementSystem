<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Loan;
use App\Models\Member;
use App\Models\LoanProposal;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Loan>
 */
class LoanFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Loan::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'loan_proposal_id' => LoanProposal::factory(),
            'member_id' => Member::factory(),
            'loan_amount' => $this->faker->numberBetween(1000, 10000),
            'disbursed_amount' => $this->faker->numberBetween(1000, 10000),
            'remaining_amount' => $this->faker->numberBetween(0, 10000),
            'interest_rate' => $this->faker->randomFloat(2, 1, 10),
            'penalty_rate' => $this->faker->randomFloat(2, 0.1, 2),
            'installment_count' => $this->faker->numberBetween(1, 12),
            'installment_type' => $this->faker->randomElement(['daily', 'weekly', 'monthly']),
            'status' => $this->faker->randomElement(['active', 'completed']),
            'disbursement_date' => $this->faker->date(),
            'remarks' => $this->faker->sentence(),
        ];
    }
}
