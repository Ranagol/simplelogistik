<?php

namespace Database\Seeders;

use App\Models\TmsCargoOrder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TmsCargoOrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // TmsCargoOrder::factory(config('constants.numberOfDbRecords'))->create();
        for ($i=1; $i <= config('constants.numberOfDbRecords'); $i++) { 
            TmsCargoOrder::factory()->create([
                'customer_id' => $i,
                'contact_id' => $i,
                'pickup_address_id' => $i,
                'delivery_address_id' => $i+1,
            ]);
        }
    }
}
