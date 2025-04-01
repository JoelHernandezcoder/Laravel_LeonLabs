<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Supply>
 */
class SupplyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->unique()->word(),
            'stock' => $this->faker->randomFloat(2, 1000, 10000),
            'unit_code' => $this->faker->randomElement(['kg', 'lt', 'm']),
            'price' => $this->faker->randomFloat(2, 1, 10),
            'supplier' =>  $this->faker->company(),
            'entry_date' => $this->faker->dateTimeThisMonth(),
            'expiration_date' =>  $this->faker->dateTimeBetween('now','1 year'),
        ];
    }
}
