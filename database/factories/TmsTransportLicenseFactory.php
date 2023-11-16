<?php

namespace Database\Factories;

use App\Models\TmsTransportLicense;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Tms_transportlicense>
 */
class TmsTransportLicenseFactory extends Factory
{
    protected $model = TmsTransportLicense::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'forwarder_id' => $this->faker->numberBetween(1, config('constants.numberOfDbRecords')),
            'license_number' => $this->faker->numerify('######'),
            'license_name' => $this->faker->word(),
            'license_valid_from' => $this->faker->date(),
            'license_valid_till' => $this->faker->date(),
        ];
    }
}
