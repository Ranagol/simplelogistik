<?php

namespace Database\Factories;

use App\Models\TmsContact;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Tms_contact>
 */
class TmsContactFactory extends Factory
{
    protected $model = TmsContact::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'customer_id' => $this->faker->numberBetween(1, config('constants.numberOfDbRecords')),
            'forwarder_id' => $this->faker->numberBetween(1, config('constants.numberOfDbRecords')),

            /**
             * This is a simple way to assure that about 90% of the orders will NOT belong to a 
             * partner. When it belongs to a partner, then it is partner_id = 1. 
             */
            'partner_id' => Arr::random([
                null, null, null, null, null, null, null, null, null, null, null, null, null, null, 1,
            ]),
            'salutation' => $this->faker->title,
            'title' => $this->faker->jobTitle,
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'phone_number' => $this->faker->phoneNumber,
            'email' => $this->faker->unique()->safeEmail,
            'comments' => $this->faker->sentence,
        ];
    }
}
