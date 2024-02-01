<?php

namespace Database\Factories;

use App\Models\TmsOrder;
use App\Models\TmsCustomer;
use App\Models\TmsPaymentMethod;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TmsNativeOrder>
 */
class TmsNativeOrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'order_id' => $this->faker->unique()->numberBetween(1, config('constants.numberOfDbRecords')/2),
            'calculation_model_name' => $this->faker->word,
            'order_number' => $this->faker->unique()->numerify('#######'),
            'order_pdf' => $this->faker->url,
            'date_of_sale' => $this->faker->date(),
            'date_of_cancellation' => $this->faker->date(),
            'description_of_transport' => $this->faker->sentence($nbWords = 3),
            'particularities' => $this->faker->sentence,
            'loading_meter' => $this->faker->randomFloat(2, 0, 100),
            'square_meter' => $this->faker->randomFloat(2, 0, 100),
            'total_weight' => $this->faker->randomFloat(2, 0, 100),
            'qubic_meter' => $this->faker->randomFloat(2, 0, 100),
            'calculated_transport_price' => $this->faker->randomFloat(2, 0, 1000),
            'transport_price_gross' => $this->faker->randomFloat(2, 0, 1000),
            'transport_price_vat' => $this->faker->randomFloat(2, 0, 200),
            'transport_price_net' => $this->faker->randomFloat(2, 0, 800),
            'customized_price_change' => $this->faker->randomFloat(2, 0, 100),
            'customized_price_mode' => $this->faker->randomElement(['increase', 'decrease']),
            'discount' => $this->faker->randomFloat(2, 0, 50),
            'price_gross' => $this->faker->randomFloat(2, 0, 1000),
            'price_vat' => $this->faker->randomFloat(2, 0, 200),
            'price_net' => $this->faker->randomFloat(2, 0, 800),
            'price_fuel_surcharge' => $this->faker->randomFloat(2, 0, 100),
            'vat_rate' => $this->faker->randomFloat(2, 0, 20),
            'value_insured' => $this->faker->randomFloat(2, 0, 10000),
            'value_of_goods' => $this->faker->randomFloat(2, 0, 10000),
            'distance_km' => $this->faker->randomFloat(2, 0, 1000),
            'duration_minutes' => $this->faker->numberBetween(0, 600),
        ];
    }
}
