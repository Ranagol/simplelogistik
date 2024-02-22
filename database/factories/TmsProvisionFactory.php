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
             * There will be 3 provisions faked. These 3 provisions can easily belong to one partner.
             * So, the number 1 here is realistic.
             */
            'partner_id' => 1,
            'value' => $this->faker->randomElement([6,8]),
            'valid_from' => '2023-01-01',
            'valid_to' => '2025-12-31', 
        ];
    }
}
