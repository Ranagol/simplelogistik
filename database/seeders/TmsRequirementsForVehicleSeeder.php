<?php

namespace Database\Seeders;

use Database\Factories\TmsRequirementsForVehicleFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TmsRequirementsForVehicleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TmsRequirementsForVehicleFactory::new()->count(config('constants.numberOfDbRecords'))->create();
    }
}
