<?php

namespace Database\Seeders;

use App\Models\TmsOrderHistory;
use Illuminate\Database\Seeder;
use Database\Factories\TmsOrderHistoryFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TmsOrderHistorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // TmsOrderHistoryFactory::new()->count(config('constants.numberOfDbRecords'))->create();
        for ($i=1; $i <= config('constants.numberOfDbRecords'); $i++) { 
            TmsOrderHistory::factory()->create([
                'order_id' => $i,
                'forwarder_id' => $i,
                'customer_id' => $i,
                'forwarding_contract_id' => $i,
            ]);
            TmsOrderHistory::factory()->create([
                'order_id' => $i,
                'forwarder_id' => $i,
                'customer_id' => $i,
                'forwarding_contract_id' => $i,
            ]);
            TmsOrderHistory::factory()->create([
                'order_id' => $i,
                'forwarder_id' => $i,
                'customer_id' => $i,
                'forwarding_contract_id' => $i,
            ]);
        }

    }
}
