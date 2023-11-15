<?php

namespace Database\Factories;

use App\Models\TmsForwarder;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Tms_forwarder>
 */
class TmsForwarderFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = TmsForwarder::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'internal_fid' => $this->faker->regexify('[A-Z0-9]{4} [A-Z0-9]{4} [A-Z0-9]{4} [A-Z0-9]{4} [A-Z0-9]{4} [A-Z0-9]{4} [A-Z0-9]{4} [A-Z0-9]{4}'),
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'company_name' => $this->faker->company,
            'tax_number' => $this->faker->randomNumber(9, true),
            'rating' => $this->faker->numberBetween(1, 5),
            'comments' => $this->faker->sentence,
        ];
    }
}
