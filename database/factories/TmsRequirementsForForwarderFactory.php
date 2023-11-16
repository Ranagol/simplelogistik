<?php

namespace Database\Factories;

use App\Models\TmsRequirementsForForwarder;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Tms_needsoptionstoforwarder>
 */
class TmsRequirementsForForwarderFactory extends Factory
{
    protected $model = TmsRequirementsForForwarder::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'requirements_id' => $this->faker->numberBetween(1, config('constants.numberOfDbRecords')),
            'forwarder_id' => $this->faker->numberBetween(1, config('constants.numberOfDbRecords')),
        ];
    }
}
