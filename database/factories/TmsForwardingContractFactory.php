<?php

namespace Database\Factories;

use App\Models\TmsForwardingContract;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Tms_forwardingcontract>
 */
class TmsForwardingContractFactory extends Factory
{
    protected $model = TmsForwardingContract::class;
    
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'internal_fcid' => $this->faker->uuid(),
            'order_id' => $this->faker->numberBetween(1, config('constants.numberOfDbRecords')),
            'forwarder_id' => $this->faker->numberBetween(1, config('constants.numberOfDbRecords')),
            'customer_id' => $this->faker->numberBetween(1, config('constants.numberOfDbRecords')),
            'vehicle_id' => $this->faker->numberBetween(1, config('constants.numberOfDbRecords')),
            'user_id' => $this->faker->numberBetween(1, config('constants.numberOfDbRecords')),
            'comments' => $this->faker->sentence(),
        ];
    }
}
