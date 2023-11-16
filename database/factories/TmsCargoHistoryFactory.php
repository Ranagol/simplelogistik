<?php

namespace Database\Factories;

use App\Models\TmsCargoHistory;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Tms_forwardingprocess>
 */
class TmsCargoHistoryFactory extends Factory
{
    protected $model = TmsCargoHistory::class;

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
            'forwarder_id' => $this->faker->numberBetween(1, config('constants.numberOfDbRecords')),
            'customer_id' => $this->faker->numberBetween(1, config('constants.numberOfDbRecords')),
            'cargo_order_id' => $this->faker->numberBetween(1, config('constants.numberOfDbRecords')),
            'forwarding_contract_id' => $this->faker->numberBetween(1, config('constants.numberOfDbRecords')),
        ];
    }
}
