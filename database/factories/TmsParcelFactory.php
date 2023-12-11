<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TmsParcel>
 */
class TmsParcelFactory extends Factory
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
            'width' => $this->faker->numberBetween(1, 100),
            'height' => $this->faker->numberBetween(1, 100),
            'length' => $this->faker->numberBetween(1, 100),
            'weight' => $this->faker->randomFloat(2, 0.1, 100),
            'is_hazardous' => $this->faker->boolean,
            'is_stackable' => $this->faker->boolean,
            'information' => $this->faker->sentence,
            'name' => $this->faker->numberBetween(1, 4),//this will be solved with mutators and accessors
            'number' => $this->faker->numberBetween(1, 100),
        ];
    }
}
