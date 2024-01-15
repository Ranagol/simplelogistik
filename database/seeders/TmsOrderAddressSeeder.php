<?php

namespace Database\Seeders;

use App\Models\TmsOrderAddress;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TmsOrderAddressSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        /**
         * constants.numberOfDbRecords is a constant. It should be 20. It means that in a general case
         * we want 20 customers created, 20 orders created... so on, in the db. In general case.
         * We want 4 addresses for every customer. The address type should be 1,2,3,4 once for every
         * customer. So, we want 20 customers, and for every customer we want 4 addresses. That is
         * 20*4 = 80 addresses. We want 80 addresses in the database. This is what we do here.
         */
        for ($i=1; $i <= config('constants.numberOfDbRecords'); $i++) { 

            /**
             * Currently, there are 4 address types in TmsOrderAddress. For every address type, we 
             * want to create 20 addresses.
             */
            foreach (TmsOrderAddress::ADDRESS_TYPES as $addressType) {
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
