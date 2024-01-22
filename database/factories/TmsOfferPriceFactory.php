<?php

namespace Database\Factories;

use App\Models\TmsOfferPrice;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Tms_offerprice>
 */
class TmsOfferPriceFactory extends Factory
{
    protected $model = TmsOfferPrice::class;
    
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->word(),
            'description' => $this->faker->sentence(),
            'offer_from' => $this->faker->dateTimeBetween('-1 month', '+1 month'),
            'offer_to' => $this->faker->dateTimeBetween('+1 month', '+2 months'),
            'forwarder_id' => $this->faker->numberBetween(1, config('constants.numberOfDbRecords')),
            'order_id' => $this->faker->numberBetween(1, config('constants.numberOfDbRecords')),
            'offered_price' => $this->faker->randomFloat(2, 0, 10000),
            'offered_price_net' => $this->faker->randomFloat(2, 0, 10000),
        ];
    }
}
