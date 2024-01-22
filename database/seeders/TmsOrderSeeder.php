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
            TmsOrder::factory()->create([
                'customer_id' => $i,
                'contact_id' => $i,
                'forwarder_id' => $i,
            ]);
        }
    }
}
