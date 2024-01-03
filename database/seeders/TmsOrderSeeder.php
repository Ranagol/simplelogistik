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
        // TmsOrder::factory(config('constants.numberOfDbRecords'))->create();
        for ($i=1; $i <= config('constants.numberOfDbRecords'); $i++) { 
            TmsOrder::factory()->create([
                'customer_id' => $i,
                'contact_id' => $i,
                'pickup_address_id' => $i,
                'delivery_address_id' => $i+1,
            ]);
        }
    }
}
