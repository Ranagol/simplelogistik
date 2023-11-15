<?php

namespace Database\Seeders;

use App\Models\TmsVehicle;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TmsVehicleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TmsVehicle::factory(config('constants.numberOfDbRecords'))->create();
    }
}
