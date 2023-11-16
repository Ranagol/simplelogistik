<?php

namespace Database\Factories;

use App\Models\TmsRequirementsForVehicle;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Tms_needsoptionstovehicle>
 */
class TmsRequirementsForVehicleFactory extends Factory
{
    protected $model = TmsRequirementsForVehicle::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'requirements_id' => $this->faker->numberBetween(1, config('constants.numberOfDbRecords')),
            'vehicle_id' => $this->faker->numberBetween(1, config('constants.numberOfDbRecords')),
        ];
    }
}
