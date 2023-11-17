<?php

namespace Database\Seeders;

use App\Models\TmsRequirement;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TmsRequirementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TmsRequirement::factory()->count(config('constants.numberOfDbRecords'))->create();
    }
}
