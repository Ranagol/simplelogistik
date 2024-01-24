<?php

namespace Database\Factories;

use App\Models\TmsOrderHistory;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Tms_forwardingprocess>
 */
class TmsOrderHistoryFactory extends Factory
{
    protected $model = TmsOrderHistory::class;

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
            'order_status' => $this->faker->randomElement(['pending', 'processing', 'completed', 'cancelled']),
            'additional_cost' => $this->faker->randomFloat(2, 0, 1000), // 2 decimal places, min 0, max 1000
            'forwarder_id' => $this->faker->numberBetween(1, config('constants.numberOfDbRecords')),
            'customer_id' => $this->faker->numberBetween(1, config('constants.numberOfDbRecords')),
            'order_id' => $this->faker->numberBetween(1, config('constants.numberOfDbRecords')),
            'forwarding_contract_id' => $this->faker->numberBetween(1, config('constants.numberOfDbRecords')),
            'user_id' => $this->faker->numberBetween(1, config('constants.numberOfDbRecords')),
        ];
    }
}
