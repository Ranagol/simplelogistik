<?php

namespace Database\Seeders;

use Database\Factories\TmsVehicleReqFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TmsVehicleReqSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TmsVehicleReqFactory::new()->count(config('constants.numberOfDbRecords'))->create();
    }
}
