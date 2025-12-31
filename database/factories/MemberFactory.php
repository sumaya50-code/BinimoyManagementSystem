<?php

namespace Database\Factories;

use App\Models\Member;
use Illuminate\Database\Eloquent\Factories\Factory;

class MemberFactory extends Factory
{
    protected $model = Member::class;

    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'phone' => $this->faker->phoneNumber,
            'address' => $this->faker->address,
            'nid' => $this->faker->unique()->numerify('##########'),
            'business_type' => $this->faker->randomElement(['Agriculture', 'Business', 'Service', 'Other']),
            'admission_date' => $this->faker->date(),
            'status' => 'active',
        ];
    }
}
