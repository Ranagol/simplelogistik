<?php

namespace Database\Factories;

use App\Models\TmsRequirementsForCustomer;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Tms_needsoptionstocustomer>
 */
class TmsRequirementsForCustomerFactory extends Factory
{
    protected $model = TmsRequirementsForCustomer::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'requirements_id' => $this->faker->numberBetween(1, config('constants.numberOfDbRecords')),
            'customer_id' => $this->faker->numberBetween(1, config('constants.numberOfDbRecords')),
        ];
    }
}
