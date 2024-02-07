<?php

namespace Database\Seeders;

use App\Models\TmsInvoice;
use Illuminate\Database\Seeder;
use App\Models\TmsInvoiceStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TmsInvoiceStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $statuses = TmsInvoiceStatus::INVOICE_STATUSES;
        foreach ($statuses as $status) {
            TmsInvoiceStatus::factory()->create([
                'internal_name' => $status,
            ]);
        }
    }
}
