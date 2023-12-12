<?php

namespace Database\Factories;

use App\Models\TmsInvoice;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Tms_invoice>
 */
class TmsInvoiceFactory extends Factory
{
    protected $model = TmsInvoice::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'cargo_order_id' => $this->faker->numberBetween(1, config('constants.numberOfDbRecords')),
            'customer_id' => $this->faker->numberBetween(1, config('constants.numberOfDbRecords')),
            'forwarder_id' => $this->faker->numberBetween(1, config('constants.numberOfDbRecords')),
            'invoice_number' => $this->faker->bothify('INV-####'),
            'invoice_date' => $this->faker->dateTime(),
            'invoice_received_date' => $this->faker->dateTime(),
            'currency' => $this->faker->currencyCode(),
            'invoice_sum' => $this->faker->randomFloat(2, 0, 10000),
            'tax' => $this->faker->randomFloat(2, 0, 1000),
        ];
    }
}
