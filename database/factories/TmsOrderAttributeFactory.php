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
            'name' => $this->faker->name,
            'name_from_partner' => $this->faker->name,
            'partner_id' => 1,//1 = Pamyra
            'price' => $this->faker->numberBetween(100, 1000),
            'description' => $this->faker->sentence,
            'from_date' => $this->faker->dateTimeBetween('-2 year', '-1 year'),
            'to_date' => $this->faker->dateTimeBetween('+1 year', '+2 year'),
        ];
    }
}
