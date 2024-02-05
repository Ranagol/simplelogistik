<?php

namespace Database\Factories;

use App\Models\TmsEmonsInvoice;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TmsEmonsInvoice>
 */
class TmsEmonsInvoiceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = TmsEmonsInvoice::class;
    
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'emons_invoice_number' => $this->faker->unique()->numerify('##########'),
            'billing_date' => $this->faker->date(),
            'order_number' => $this->faker->unique()->numerify('##########'),
            'customer_name' => $this->faker->name(),
            'customer_country_code' => $this->faker->countryCode(),
            'customer_zip_code' => $this->faker->postcode(),
            'customer_city' => $this->faker->city(),
            'receiver_name' => $this->faker->name(),
            'receiver_country_code' => $this->faker->countryCode(),
            'receiver_zip_code' => $this->faker->postcode(),
            'receiver_city' => $this->faker->city(),
            'netto_price' => $this->faker->randomFloat(2, 1, 100),
            'is_correct' => null,
        ];
    }
}
