<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TmsInvoiceHistory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TmsInvoiceHistorySeeder extends Seeder
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
            TmsInvoiceHistory::factory()->create([
                'invoice_id' => $i,
                'forwarder_id' => $i,
                'customer_id' => $i,
                'forwarding_contract_id' => $i,
                'user_id' => $i,
            ]);
            TmsInvoiceHistory::factory()->create([
                'invoice_id' => $i,
                'forwarder_id' => $i,
                'customer_id' => $i,
                'forwarding_contract_id' => $i,
                'user_id' => $i,
            ]);
            TmsInvoiceHistory::factory()->create([
                'invoice_id' => $i,
                'forwarder_id' => $i,
                'customer_id' => $i,
                'forwarding_contract_id' => $i,
                'user_id' => $i,
            ]);
        }
    }
}
