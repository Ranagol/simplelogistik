<?php

namespace Database\Factories;

use App\Models\TmsAddress;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Tms_address>
 */
class TmsAddressFactory extends Factory
{
    protected $model = TmsAddress::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'street' => $this->faker->streetName,
            'house_number' => $this->faker->buildingNumber,
            'zipcode' => $this->faker->postcode,
            'city' => $this->faker->city,
            'country' => $this->faker->country,
            'state' => $this->faker->state,
            'type_of_address' => $this->faker->randomElement(['Home', 'Work', 'Other']),
            'comment' => $this->faker->sentence,
            'customer_id' => $this->faker->numberBetween(1, config('constants.numberOfDbRecords')),
            'forwarder_id' => $this->faker->numberBetween(1, config('constants.numberOfDbRecords')),
        ];
    }
}
