<?php

namespace Database\Factories;

use App\Models\TmsParcel;
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
            'tms_order_id' => $this->faker->numberBetween(1, config('constants.numberOfDbRecords')),
            'is_hazardous' => $this->faker->boolean,
            'information' => $this->faker->sentence,
            'name' => $this->faker->randomElement(TmsParcel::getAllParcelTypes()),
            'height' => $this->faker->randomFloat(2, 0, 200),
            'length' => $this->faker->randomFloat(2, 0, 200),
            'width' => $this->faker->randomFloat(2, 0, 200),
            'number' => $this->faker->unique()->numerify('Parcel ####'),
            'stackable' => $this->faker->boolean,
            'weight' => $this->faker->randomFloat(2, 0, 100),
        ];
    }
}
