<?php

namespace Database\Factories;

use App\Models\TmsPartner;
use App\Models\TmsOrderStatus;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TmsOrderStatus>
 */
class TmsOrderStatusFactory extends Factory
{
    protected $model = TmsOrderStatus::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'internal_name' => $this->faker->word,
            'external_name' => $this->faker->word,
            'partner_id' => TmsPartner::where('company_name', 'Pamyra')->first()->id//because Pamyra is always 1
        ];
    }
}
