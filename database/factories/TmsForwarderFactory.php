<?php

namespace Database\Factories;

use App\Models\TmsForwarder;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Tms_forwarder>
 */
class TmsForwarderFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = TmsForwarder::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'internal_id' => $this->faker->regexify('[A-Z0-9]{4} [A-Z0-9]{4}'),
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'company_name' => $this->faker->company,
            'tax_number' => $this->faker->randomNumber(9, true),
            'rating' => $this->faker->numberBetween(1, 5),
            'forwarder_type' => Arr::random(TmsForwarder::FORWARDER_TYPES),
            'comments' => $this->faker->sentence,
            // 'url_logo' => $this->faker->imageUrl(),
            'url_logo' => $this->getRandomLogo(),
        ];
    }

    private function getRandomLogo(){
        return \Arr::random($this->LOGOS);
    }

    private $LOGOS = [
        "https://upload.wikimedia.org/wikipedia/commons/thumb/6/6b/United_Parcel_Service_logo_2014.svg/1718px-United_Parcel_Service_logo_2014.svg.png",
        "https://upload.wikimedia.org/wikipedia/commons/thumb/b/b3/DHL_Express_logo.svg/2560px-DHL_Express_logo.svg.png",
        "https://upload.wikimedia.org/wikipedia/commons/thumb/4/46/TNT_Logo.svg/2560px-TNT_Logo.svg.png",
        "https://upload.wikimedia.org/wikipedia/commons/thumb/9/9d/FedEx_Express.svg/1200px-FedEx_Express.svg.png"
    ];
}
