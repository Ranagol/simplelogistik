<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TmsCustomerReq;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TmsCustomerReqSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TmsCustomerReq::factory(config('constants.numberOfDbRecords'))->create();
    }
}
