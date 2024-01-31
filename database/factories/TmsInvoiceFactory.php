<?php

namespace Database\Factories;

use App\Models\TmsInvoice;
use App\Models\TmsInvoiceStatus;
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
            'order_id' => $this->faker->numberBetween(1, config('constants.numberOfDbRecords')),
            'customer_id' => $this->faker->numberBetween(1, config('constants.numberOfDbRecords')),
            'forwarder_id' => $this->faker->numberBetween(1, config('constants.numberOfDbRecords')),
            'invoice_status_id' => $this->faker->numberBetween(
                1,
                count(TmsInvoiceStatus::INVOICE_STATUSES)
            ),
            'invoice_number' => $this->faker->bothify('INV-####'),
            'invoice_type' => $this->faker->numberBetween(1, 2),
            'invoice_link' => $this->faker->url(),
            'payment_date' => $this->faker->dateTime(),
            'invoice_date' => $this->faker->dateTime(),
            'invoice_received_date' => $this->faker->dateTime(),
            'invoice_sum_without_tax' => $this->faker->randomFloat(2, 0, 10000),
            'invoice_sum_with_tax' => $this->faker->randomFloat(2, 0, 10000),
            'tax' => $this->faker->randomFloat(2, 0, 1000),
        ];
    }
}
