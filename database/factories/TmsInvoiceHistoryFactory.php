<?php

namespace Database\Factories;

use App\Models\TmsInvoice;
use App\Models\TmsInvoiceStatus;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TmsInvoiceHistory>
 */
class TmsInvoiceHistoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->word(),
            'comment' => $this->faker->sentence(),
            'invoice_status' => $this->faker->randomElement(TmsInvoiceStatus::INVOICE_STATUSES),
            'additional_cost' => $this->faker->randomFloat(2, 0, 1000), // 2 decimal places, min 0, max 1000
            'forwarder_id' => $this->faker->numberBetween(1, config('constants.numberOfDbRecords')),
            'customer_id' => $this->faker->numberBetween(1, config('constants.numberOfDbRecords')),
            'invoice_id' => $this->faker->numberBetween(1, config('constants.numberOfDbRecords')),
            'forwarding_contract_id' => $this->faker->numberBetween(1, config('constants.numberOfDbRecords')),
            'user_id' => $this->faker->numberBetween(1, config('constants.numberOfDbRecords')),
        ];
    }
}
