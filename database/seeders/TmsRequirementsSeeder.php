<?php

namespace Database\Seeders;

use App\Models\TmsRequirements;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TmsRequirementsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TmsRequirements::factory()->count(config('constants.numberOfDbRecords'))->create();
    }
}
