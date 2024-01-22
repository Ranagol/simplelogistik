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
            //Reminder: p_ means that this column comes from Pamyra
            'p_name' => $this->faker->randomElement(TmsParcel::PARCEL_TYPE),//Since package type is called p_name in Pamyra, we use it here
            'p_height' => $this->faker->randomFloat(2, 0, 200),
            'p_length' => $this->faker->randomFloat(2, 0, 200),
            'p_width' => $this->faker->randomFloat(2, 0, 200),
            'p_number' => $this->faker->unique()->numerify('Parcel ####'),
            'p_stackable' => $this->faker->boolean,
            'p_weight' => $this->faker->randomFloat(2, 0, 100),
        ];
    }
}
