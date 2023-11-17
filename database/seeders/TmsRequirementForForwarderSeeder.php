<?php

namespace Database\Seeders;

use Database\Factories\TmsRequirementForForwarderFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TmsRequirementForForwarderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TmsRequirementForForwarderFactory::new()->count(config('constants.numberOfDbRecords'))->create();
    }
}
