<?php

namespace Database\Factories;

use App\Models\TmsPartner;
use App\Models\TmsPaymentMethod;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TmsPaymentMethod>
 */
class TmsPaymentMethodFactory extends Factory
{

    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = TmsPaymentMethod::class;
    
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
            'partner_id' => TmsPartner::where('company_name', 'Pamyra')->first()->id,
        ];
    }
}
