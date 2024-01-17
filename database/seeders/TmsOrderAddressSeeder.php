<?php

namespace Database\Seeders;

use App\Models\TmsOrderAddress;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TmsOrderAddressSeeder extends Seeder
{
    /**
     * We want every order to have 4 addresses. 2 pickup and 2 delivery addresses. We achive this
     * with this hard coded array.
     *
     * @var array
     */
    protected array $addressTypes = [
        'Pickup address',
        'Pickup address',
        'Delivery address',
        'Delivery address',
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        /**
         * FOR EACH ORDER...
         */
        for ($i=1; $i <= config('constants.numberOfDbRecords'); $i++) { 

            /**
             * ...CREATE 2 pickup and two delivery order_addresses
             */
            foreach ($this->addressTypes as $key => $addressType) {
                // dump($addressType);
                //TODO ANDOR something is not working here as it should. Check, correct.
                TmsOrderAddress::factory()->create([

                    /**
                     * Here we explicitly define the value of the address_type and the customer_id.
                     * All other columns will be defined by the  factory faker.
                     */
                    'address_type' => $addressType,
                    'order_id' => $i,
                    'customer_id' => $i,
                    'forwarder_id' => $i,
                    // partner_id is defined in the factory 
                ]);
            }
        }
    }
}
