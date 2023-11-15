<?php

namespace Database\Factories;

use App\Models\TmsVehicle;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Tms_vehicle>
 */
class TmsVehicleFactory extends Factory
{
    protected $model = TmsVehicle::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->word,
            'max_weight' => $this->faker->randomFloat(2, 1, 100),
            'max_pickup_weight' => $this->faker->randomFloat(2, 1, 100),
            'max_pickup_width' => $this->faker->randomFloat(2, 1, 100),
            'max_pickup_height' => $this->faker->randomFloat(2, 1, 100),
            'max_pickup_length' => $this->faker->randomFloat(2, 1, 100),
            'vehicle_type' => $this->faker->randomElement(['Truck', 'Van', 'Car']),
            'plate_number' => $this->faker->bothify('??###'),
            'forwarder_id' => $this->faker->numberBetween(1, config('constants.numberOfDbRecords')),
            'address_id' => $this->faker->numberBetween(1, config('constants.numberOfDbRecords')),
        ];
    }
}
