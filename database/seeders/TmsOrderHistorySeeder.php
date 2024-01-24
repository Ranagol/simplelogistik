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
        /**
         * We have 20 orders. For every order make 3 order histories, with these fixed ids.
         */
        for ($i=1; $i <= config('constants.numberOfDbRecords'); $i++) { 
            TmsOrderHistory::factory()->create([
                'order_id' => $i,
                'forwarder_id' => $i,
                'customer_id' => $i,
                'forwarding_contract_id' => $i,
                'user_id' => $i,
            ]);
            TmsOrderHistory::factory()->create([
                'order_id' => $i,
                'forwarder_id' => $i,
                'customer_id' => $i,
                'forwarding_contract_id' => $i,
                'user_id' => $i,
            ]);
            TmsOrderHistory::factory()->create([
                'order_id' => $i,
                'forwarder_id' => $i,
                'customer_id' => $i,
                'forwarding_contract_id' => $i,
                'user_id' => $i,
            ]);
        }

    }
}
