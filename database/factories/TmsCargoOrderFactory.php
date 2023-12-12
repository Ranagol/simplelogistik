<?php

namespace Database\Factories;

use App\Models\TmsCargoOrder;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Tms_cargoorder>
 */
class TmsCargoOrderFactory extends Factory
{
    protected $model = TmsCargoOrder::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'order_number' => $this->faker->uuid,
            'customer_id' => $this->faker->numberBetween(1, config('constants.numberOfDbRecords')),
            'contact_id' => $this->faker->numberBetween(1, config('constants.numberOfDbRecords')),
            'pickup_address_id' => $this->faker->numberBetween(1, config('constants.numberOfDbRecords')),
            'delivery_address_id' => $this->faker->numberBetween(1, config('constants.numberOfDbRecords')),
            'description' => $this->faker->sentence,
            'origin' => $this->faker->randomElement(['Pamyra', 'Sales', 'Google Ads', 'Shipping calc.']),
            'customer_reference' => $this->faker->sentence(3),
            'shipping_price' => $this->faker->randomFloat(2, 1, 100),
            'shipping_price_netto' => $this->faker->randomFloat(2, 1, 100),

            'avis_customer_phone' => $this->faker->phoneNumber,
            'avis_sender_phone' => $this->faker->phoneNumber,
            'avis_receiver_phone' => $this->faker->phoneNumber,

            'pickup_date_from' => $this->faker->dateTimeBetween('-1 week', '+1 week'),
            'pickup_date_to' => $this->faker->dateTimeBetween('+1 week', '+2 weeks'),
            'pickup_comments' => $this->faker->sentence,

            'delivery_date_from' => $this->faker->dateTimeBetween('+2 weeks', '+3 weeks'),
            'delivery_date_to' => $this->faker->dateTimeBetween('+3 weeks', '+4 weeks'),
            'delivery_comments' => $this->faker->sentence,
            
        ];
    }
}
