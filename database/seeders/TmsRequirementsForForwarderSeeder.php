<?php

namespace Database\Seeders;

use Database\Factories\TmsRequirementsForForwarderFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TmsRequirementsForForwarderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TmsRequirementsForForwarderFactory::new()->count(config('constants.numberOfDbRecords'))->create();
    }
}
