<?php

namespace Database\Factories;

use App\Models\TmsInvoiceStatus;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TmsInvoiceStatus>
 */
class TmsInvoiceStatusFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = TmsInvoiceStatus::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            //All relevant columns are nullable here, except the internal_name
            'description' => $this->faker->word,
        ];
    }
}
