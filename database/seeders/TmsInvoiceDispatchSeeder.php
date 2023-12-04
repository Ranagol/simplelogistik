<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TmsInvoiceDispatch;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TmsInvoiceDispatchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TmsInvoiceDispatch::factory()->count(2)->create();
    }
}
