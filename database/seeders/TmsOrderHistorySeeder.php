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
                'user_id' => $this->createUserId($i),
                'cronjob_name' => $this->createCronjobName($i),
            ]);
            TmsOrderHistory::factory()->create([
                'order_id' => $i,
                'forwarder_id' => $i,
                'customer_id' => $i,
                'forwarding_contract_id' => $i,
                'user_id' => $this->createUserId($i),
                'cronjob_name' => $this->createCronjobName($i),
            ]);
            TmsOrderHistory::factory()->create([
                'order_id' => $i,
                'forwarder_id' => $i,
                'customer_id' => $i,
                'forwarding_contract_id' => $i,
                'user_id' => $this->createUserId($i),
                'cronjob_name' => $this->createCronjobName($i),
            ]);
        }
    }

    /**
     * Undocumented function
     *
     * @param integer $i
     * @return void
     */
    private function createCronjobName(int $i): string | null
    {
        if ($i % 2 === 0) {
            return null;    
        }
        return 'cronjob_name';
    }

    private function createUserId(int $i): int | null
    {
        if ($i % 2 === 0) {
            return $i;
        }
        return null;
    }
}
