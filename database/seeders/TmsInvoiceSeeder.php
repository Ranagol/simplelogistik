<?php

namespace Database\Seeders;

use Database\Factories\TmsInvoiceFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TmsInvoiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TmsInvoiceFactory::new()->count(config('constants.numberOfDbRecords'))->create();
    }
}
