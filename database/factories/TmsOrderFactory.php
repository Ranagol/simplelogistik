<?php

namespace Database\Factories;

use App\Models\TmsOrder;
use Illuminate\Support\Arr;
use App\Models\TmsOrderStatus;
use Illuminate\Database\Eloquent\Factories\Factory;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Tms_order>
 */
class TmsOrderFactory extends Factory
{
    protected $model = TmsOrder::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'customer_id' => $this->faker->numberBetween(1, config('constants.numberOfDbRecords')),
            'contact_id' => $this->faker->numberBetween(1, config('constants.numberOfDbRecords')),
            'forwarder_id' => $this->faker->numberBetween(1, config('constants.numberOfDbRecords')),
            'order_status_id' => $this->faker->numberBetween(
                1, 
                count(TmsOrderStatus::STATUSES)
            ),

            /**
             * This is a simple way to assure that about 90% of the orders will NOT belong to a 
             * partner. When it belongs to a partner, then it is partner_id = 1. 
             */
            'partner_id' => Arr::random([
                null, null, null, null, null, null, null, null, null, null, null, null, null, null, 1,
            ]),

            'type_of_transport' => $this->faker->randomElement(TmsOrder::TYPES_OF_TRANSPORT),
            'origin' => $this->faker->randomElement(TmsOrder::ORIGINS),
            'customer_reference' => $this->faker->numerify('#######'),
            'provision' => $this->faker->randomFloat(2, 0, 10),//provision should be less than 10%
            'order_date' => $this->faker->date(),
            'purchase_price' => $this->faker->randomFloat(2, 0, 1000),
            'month_and_year' => $this->faker->monthName() . ' - ' . $this->faker->year(),
            'shipping_label_pdf' => $this->faker->url,
            // 'order_number' => $this->faker->numerify('#######'),
            'order_number' => 666666,
        ];
    }
}
