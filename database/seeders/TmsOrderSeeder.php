<?php

namespace Database\Seeders;

use App\Models\TmsOrder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TmsOrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        /**
         * Here we create 20 orders. The order nr 1 will have 1 for customer_id, contact_id, 
         * pickup_address_id and delivery_address_id. All 1. Then same for order nr 2.
         * This can work only when we have 20 customers and 20 contacts in the database.
         * Which we have.
         */
        for ($i=1; $i <= config('constants.numberOfDbRecords'); $i++) { 

            /**
             * From the 20 orders that will be created, orders 1 - 10 should be 'Sales' origin,
             * orders 11 - 20 should be 'Pamyra'.
             */
            $origin = '';
            if ( $i < 11) {
                $origin = 'Sales';
            } else {
                $origin = 'Pamyra';
            }

            TmsOrder::factory()->create([
                'customer_id' => $i,
                'contact_id' => $i,
                'forwarder_id' => $i,
                'origin' => $origin,
            ]);
        }
    }
}
