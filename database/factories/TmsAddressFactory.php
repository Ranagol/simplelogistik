<?php

namespace Database\Factories;

use App\Models\TmsAddress;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

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
            'company_name' => $this->faker->company,
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'address_type' => Arr::random(TmsAddress::ADDRESS_TYPES),
            'street' => $this->faker->streetName,
            'house_number' => $this->faker->buildingNumber,
            'zip_code' => $this->faker->postcode,
            'city' => $this->faker->city,
            'country_id' => Arr::random([1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14]),//these are the ids of the countries in the database
            'state' => $this->faker->state,
            'phone' => $this->faker->phoneNumber,
            'email' => $this->faker->email,
            'address_additional_information' => $this->faker->sentence,
            'customer_id' => $this->faker->numberBetween(1, config('constants.numberOfDbRecords')),
            'forwarder_id' => $this->faker->numberBetween(1, config('constants.numberOfDbRecords')),
        ];
    }
}
