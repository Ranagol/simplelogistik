<?php

namespace Database\Factories;

use App\Models\TmsContact;
use Illuminate\Database\Eloquent\Factories\Factory;

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
            'salutation' => $this->faker->title,
            'title' => $this->faker->jobTitle,
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'phone_number' => $this->faker->phoneNumber,
            'email' => $this->faker->unique()->safeEmail,
            'customer_id' => $this->faker->numberBetween(1, config('constants.numberOfDbRecords')),
            'forwarder_id' => $this->faker->numberBetween(1, config('constants.numberOfDbRecords')),
            'comments' => $this->faker->sentence,
        ];
    }
}
