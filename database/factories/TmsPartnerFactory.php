<?php

namespace Database\Factories;

use App\Models\TmsPartner;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TmsPartner>
 */
class TmsPartnerFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = TmsPartner::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'internal_id' => $this->faker->regexify('[A-Z0-9]{4} [A-Z0-9]{4}'),
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'company_name' => $this->faker->company,
            'tax_number' => $this->faker->randomNumber(9, true),
            'rating' => $this->faker->numberBetween(1, 5),
            'comments' => $this->faker->sentence,
        ];
    }
}
