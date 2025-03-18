<?php

namespace Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Employee>
 */
class EmployeeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

            $startDate = $this->faker->dateTimeBetween('-10 years', 'now');
            $seniority = Carbon::parse($startDate)->diffInYears(Carbon::now());

        return [
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'gender' => $this->faker->randomElement(['male', 'female', 'other']),
            'address' => $this->faker->address(),
            'meal_option' => $this->faker->randomElement(['vegetarian', 'classic', 'express']),
            'role' => $this->faker->randomElement(['manager', 'supervisor', 'worker']),
            'seniority' => $seniority,
            'salary' => $this->faker->randomFloat(2, 1000, 10000),
            'start_date' => $startDate,
        ];
    }
}
