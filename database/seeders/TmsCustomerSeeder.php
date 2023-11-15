<?php

namespace Database\Seeders;

use App\Models\TmsCustomer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TmsCustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TmsCustomer::factory()->count(config('constants.numberOfDbRecords'))->create();
    }
}
