<?php

namespace Database\Factories;

use App\Models\TmsAddress;
use App\Models\TmsCountry;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Tms_address>
 */
class TmsAddressFactory extends Factory
{
    protected $model = TmsAddress::class;

    protected array $countryNames;

    public function __construct()
    {
        parent::__construct();

        /**
         * pluck() gives us all country names from the db. toArray() converts the collection to an 
         * array. This array will be used to fake... the country_id. Yes. Since we have a mutator
         * in the TmsAddress model, we need actually to provide a valid country name. The mutator
         * will transform this country name into a valid country id. There is no other way to fake
         * the country_id.
         */
        $this->countryNames = TmsCountry::pluck('country_name')->toArray();
    }

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'company_name' => $this->faker->company,
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'address_type' => Arr::random(TmsAddress::ADDRESS_TYPES),
            'street' => $this->faker->streetName,
            'house_number' => $this->faker->buildingNumber,
            'zip_code' => $this->faker->postcode,
            'city' => $this->faker->city,
            //Takes one random country name from the array of country names
            'country_id' => Arr::random($this->countryNames),
            // 'country_id' => Arr::random(
            //     [//TODO ANDOR pull this once from the database, instead of hardcoding it here
            //         //The end result should be an array of string country names
            //         "Afghanistan",
            //         "Albania",
            //         "Algeria",
            //         "American Samoa",
            //         "Andorra",
            //         "Angola",
            //         "Anguilla",
            //         "Antarctica",
            //         "Antigua and Barbuda",
            //         "Argentina",
            //         "Armenia",
            //         "Aruba",
            //         "Australia",
            //         "Austria"
            //     ]
            // ),//these country names will become country ids in the database with a the TmsAddress::countrId() mutator
            'state' => $this->faker->state,
            'phone' => $this->faker->phoneNumber,
            'email' => $this->faker->email,
            'address_additional_information' => $this->faker->sentence,
            'customer_id' => $this->faker->numberBetween(1, config('constants.numberOfDbRecords')),
            'forwarder_id' => $this->faker->numberBetween(1, config('constants.numberOfDbRecords')),
        ];
    }
}

