<?php

namespace Database\Seeders;

use App\Models\TmsCargoHistory;
use Illuminate\Database\Seeder;
use Database\Factories\TmsCargoHistoryFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TmsCargoHistorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // TmsCargoHistoryFactory::new()->count(config('constants.numberOfDbRecords'))->create();
        for ($i=1; $i <= config('constants.numberOfDbRecords'); $i++) { 
            TmsCargoHistory::factory()->create([
                'cargo_order_id' => $i,
                'forwarder_id' => $i,
                'customer_id' => $i,
                'forwarding_contract_id' => $i,
            ]);
            TmsCargoHistory::factory()->create([
                'cargo_order_id' => $i,
                'forwarder_id' => $i,
                'customer_id' => $i,
                'forwarding_contract_id' => $i,
            ]);
            TmsCargoHistory::factory()->create([
                'cargo_order_id' => $i,
                'forwarder_id' => $i,
                'customer_id' => $i,
                'forwarding_contract_id' => $i,
            ]);
        }

    }
}
