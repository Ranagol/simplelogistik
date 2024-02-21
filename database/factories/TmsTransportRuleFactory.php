<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TmsTransportRule>
 */
class TmsTransportRuleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => Str::slug($this->faker->company . '-' . $this->faker->word),
            'description' => $this->faker->sentence,
            'condition_field' => $this->faker->word,
            'condition_content' => $this->faker->word,
            'condition_operator' => $this->faker->randomElement(['=', '!=', '>', '<', '>=', '<=']),
            'consequence' => $this->faker->sentence,
        ];
    }
}
