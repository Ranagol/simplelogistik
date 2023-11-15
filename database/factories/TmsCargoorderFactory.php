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
            'internal_oid' => $this->faker->uuid,
            'customer_id' => $this->faker->numberBetween(1, config('constants.numberOfDbRecords')),
            'contact_id' => $this->faker->numberBetween(1, config('constants.numberOfDbRecords')),
            'start_address_id' => $this->faker->numberBetween(1, config('constants.numberOfDbRecords')),
            'target_address_id' => $this->faker->numberBetween(1, config('constants.numberOfDbRecords')),
            'description' => $this->faker->sentence,
            'shipping_price' => $this->faker->randomFloat(2, 1, 100),
            'shipping_price_netto' => $this->faker->randomFloat(2, 1, 100),
            'pickup_date' => $this->faker->dateTimeBetween('-1 month', '+1 month'),
            'delivery_date' => $this->faker->dateTimeBetween('+1 month', '+2 months'),
        ];
    }
}
