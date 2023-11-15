<?php

namespace Database\Seeders;

use Database\Factories\TmsForwardingContractFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TmsForwardingContractSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TmsForwardingContractFactory::new()->count(config('constants.numberOfDbRecords'))->create();
    }
}
