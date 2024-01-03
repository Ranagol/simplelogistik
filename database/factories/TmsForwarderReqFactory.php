<?php

namespace Database\Factories;

use App\Models\TmsForwarderReq;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Tms_needsoptionstoforwarder>
 */
class TmsForwarderReqFactory extends Factory
{
    protected $model = TmsForwarderReq::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'requirement_id' => $this->faker->numberBetween(1, config('constants.numberOfDbRecords')),
            'forwarder_id' => $this->faker->numberBetween(1, config('constants.numberOfDbRecords')),
        ];
    }
}
