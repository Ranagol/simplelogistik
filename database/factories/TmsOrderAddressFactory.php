<?php

namespace Database\Factories;

use App\Models\TmsCountry;
use App\Models\TmsOrderAddress;
use Illuminate\Support\Arr;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Collection;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TmsOrderAddress>
 */
class TmsOrderAddressFactory extends Factory
{
    protected $model = TmsOrderAddress::class;
    protected array $countryIds;
    
    /**
     * If we override the constructor, we must call the parent constructor. And we must use the
     * exact arguments as the parent constructor. So we must pass the arguments from the constructor
     * to the parent constructor. How to find this arguments? We can find them in the parent class.
     * In this case the parent class is Illuminate\Database\Eloquent\Factories\Factory. 
     *
     * @param [type] $count
     * @param Collection|null $states
     * @param Collection|null $has
     * @param Collection|null $for
     * @param Collection|null $afterMaking
     * @param Collection|null $afterCreating
     * @param [type] $connection
     * @param Collection|null $recycle
     */
    public function __construct(
        $count = null,
        ?Collection $states = null,
        ?Collection $has = null,
        ?Collection $for = null,
        ?Collection $afterMaking = null,
        ?Collection $afterCreating = null,
        $connection = null,
        ?Collection $recycle = null
    )
    {
        parent::__construct(
            $count,
            $states,
            $has,
            $for,
            $afterMaking,
            $afterCreating,
            $connection,
            $recycle,
        );

        /**
         * pluck() gives us all country names from the db. toArray() converts the collection to an 
         * array. This array will be used to fake... the country_id. Yes. Since we have a mutator
         * in the TmsAddress model, we need actually to provide a valid country name. The mutator
         * will transform this country name into a valid country id. There is no other way to fake
         * the country_id.
         */
        $this->countryIds = TmsCountry::pluck('id')->toArray();
    }

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'order' => $this->faker->numberBetween(1, 10),
            'order_id' => $this->faker->numberBetween(1, config('constants.numberOfDbRecords')),
            'customer_id' => $this->faker->numberBetween(1, config('constants.numberOfDbRecords')),
            'forwarder_id' => $this->faker->numberBetween(1, config('constants.numberOfDbRecords')),
            //Takes one random country name from the array of country names
            'country_id' => Arr::random($this->countryIds),

            /**
             * This is a simple way to assure that about 90% of the addresses will NOT belong to a 
             * partner. When it belongs to a partner, then it is partner_id = 1. 
             */
            'partner_id' => Arr::random([
                null, null, null, null, null, null, null, null, null, null, null, null, null, null, 1,
            ]),
            'company_name' => $this->faker->company,
            'address_type' => Arr::random(['Pickup address', 'Delivery address']),//works with mutator/**************************** */
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'street' => $this->faker->streetName,
            'house_number' => $this->faker->buildingNumber,
            'zip_code' => $this->faker->postcode,
            'city' => $this->faker->city,
            'state' => $this->faker->state,
            'phone' => $this->faker->phoneNumber,
            'email' => $this->faker->email,
            'address_additional_information' => $this->faker->sentence,

            'avis_phone' => $this->faker->phoneNumber,
        ];
    }

    public function foo(): static
    {
        return $this->state(
            [
                'order_id' => 1,
                'customer_id' => 1,
                'forwarder_id' => 1,
            ]
        );
    }
}
