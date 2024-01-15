<?php

namespace Database\Seeders;

use App\Models\TmsGear;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TmsGearSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TmsGear::factory()->count(config('constants.numberOfDbRecords'))->create();
    }
}
