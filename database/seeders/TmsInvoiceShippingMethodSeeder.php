<?php

namespace Database\Seeders;

use App\Models\TmsInvoiceShippingMethod;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TmsInvoiceShippingMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TmsInvoiceShippingMethod::factory()->count(2)->create();
    }
}
