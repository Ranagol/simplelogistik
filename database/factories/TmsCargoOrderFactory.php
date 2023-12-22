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
            'customer_id' => $this->faker->numberBetween(1, config('constants.numberOfDbRecords')),
            'contact_id' => $this->faker->numberBetween(1, config('constants.numberOfDbRecords')),
            'pickup_address_id' => $this->faker->numberBetween(1, config('constants.numberOfDbRecords')),
            'delivery_address_id' => $this->faker->numberBetween(1, config('constants.numberOfDbRecords')),
            'type_of_transport' => $this->faker->randomElement(TmsCargoOrder::TYPES_OF_TRANSPORT),
            'origin' => $this->faker->randomElement(TmsCargoOrder::ORIGINS),
            'customer_reference' => $this->faker->numerify('#######'),
            'order_date' => $this->faker->date(),
            'purchase_price' => $this->faker->randomFloat(2, 0, 1000),
            'month_and_year' => $this->faker->monthName() . ' - ' . $this->faker->year(),

            'avis_customer_phone' => $this->faker->phoneNumber,
            'avis_sender_phone' => $this->faker->phoneNumber,
            'avis_receiver_phone' => $this->faker->phoneNumber,

            'p_calculation_model_name' => $this->faker->word,
            'p_order_number' => $this->faker->unique()->numerify('#######'),
            'p_order_pdf' => $this->faker->url,
            'p_payment_method' => $this->faker->randomElement(TmsCargoOrder::PAYMENT_METHODS),
            'p_date_of_sale' => $this->faker->date(),
            'p_date_of_cancellation' => $this->faker->date(),
            'p_pickup_date_from' => $this->faker->dateTimeBetween('-1 week', '+1 week'),
            'p_pickup_date_to' => $this->faker->dateTimeBetween('+1 week', '+2 weeks'),
            'p_pickup_comments' => $this->faker->sentence,
            'p_delivery_date_from' => $this->faker->dateTimeBetween('+2 weeks', '+3 weeks'),
            'p_delivery_date_to' => $this->faker->dateTimeBetween('+3 weeks', '+4 weeks'),
            'p_delivery_comments' => $this->faker->sentence,
            'p_description_of_transport' => $this->faker->sentence($nbWords = 3),
            'p_particularities' => $this->faker->sentence,
            'p_loading_meter' => $this->faker->randomFloat(2, 0, 100),
            'p_square_meter' => $this->faker->randomFloat(2, 0, 100),
            'p_total_weight' => $this->faker->randomFloat(2, 0, 100),
            'p_qubic_meter' => $this->faker->randomFloat(2, 0, 100),
            'p_calculated_transport_price' => $this->faker->randomFloat(2, 0, 1000),
            'p_transport_price_gross' => $this->faker->randomFloat(2, 0, 1000),
            'p_transport_price_vat' => $this->faker->randomFloat(2, 0, 200),
            'p_transport_price_net' => $this->faker->randomFloat(2, 0, 800),
            'p_customized_price_change' => $this->faker->randomFloat(2, 0, 100),
            'p_customized_price_mode' => $this->faker->randomElement(['increase', 'decrease']),
            'p_discount' => $this->faker->randomFloat(2, 0, 50),
            'p_price_gross' => $this->faker->randomFloat(2, 0, 1000),
            'p_price_vat' => $this->faker->randomFloat(2, 0, 200),
            'p_price_net' => $this->faker->randomFloat(2, 0, 800),
            'p_price_fuel_surcharge' => $this->faker->randomFloat(2, 0, 100),
            'p_vat_rate' => $this->faker->randomFloat(2, 0, 20),
            'p_value_insured' => $this->faker->randomFloat(2, 0, 10000),
            'p_value_of_goods' => $this->faker->randomFloat(2, 0, 10000),
            'p_distance_km' => $this->faker->randomFloat(2, 0, 1000),
            'p_duration_minutes' => $this->faker->numberBetween(0, 600),
        ];
    }
}
