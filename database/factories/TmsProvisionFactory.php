<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TmsProvision>
 */
class TmsProvisionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            
            /**
             * This logic is correct, but not used. There is a different logic in the seeder.
             */
            'partner_id' => 1,
            'value' => $this->faker->randomElement([6,8]),
            'valid_from' => '2023-01-01',
            'valid_to' => '2025-12-31', 
        ];
    }
}
