<?php

namespace Database\Seeders;

use Database\Factories\TmsForwarderReqFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TmsForwarderReqSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TmsForwarderReqFactory::new()->count(config('constants.numberOfDbRecords'))->create();
    }
}
