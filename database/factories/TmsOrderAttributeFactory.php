<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TmsOrderAttribute>
 */
class TmsOrderAttributeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'tms_cargo_order_id' => $this->faker->numberBetween(1, config('constants.numberOfDbRecords')),
            'type' => $this->faker->randomElement(['sms notification', 'extra packaging', 'priority delivery']),
            'price' => $this->faker->numberBetween(100, 1000),
            'description' => $this->faker->sentence,
        ];
    }
}
