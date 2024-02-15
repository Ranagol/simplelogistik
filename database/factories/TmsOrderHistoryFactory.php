<?php

namespace Database\Factories;

use App\Models\TmsOrderHistory;
use App\Models\TmsOrderStatus;
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
            'details' => $this->faker->sentence(),
            'order_status_id' => $this->faker->randomElement(TmsOrderStatus::all()->pluck('id')->toArray()),
            'additional_cost' => $this->faker->randomFloat(2, 0, 1000), // 2 decimal places, min 0, max 1000
            'forwarder_id' => $this->faker->numberBetween(1, config('constants.numberOfDbRecords')),
            'customer_id' => $this->faker->numberBetween(1, config('constants.numberOfDbRecords')),
            'order_id' => $this->faker->numberBetween(1, config('constants.numberOfDbRecords')),
            'forwarding_contract_id' => $this->faker->numberBetween(1, config('constants.numberOfDbRecords')),
            'user_id' => $this->faker->numberBetween(1, config('constants.numberOfDbRecords')),
            'cronjob_name' => $this->faker->randomElement([null, 'cronjob_name']), // 50% chance of being null
        ];
    }
}
