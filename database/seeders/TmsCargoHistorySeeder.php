<?php

namespace Database\Seeders;

use Database\Factories\TmsCargoHistoryFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TmsCargoHistorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TmsCargoHistoryFactory::new()->count(config('constants.numberOfDbRecords'))->create();
    }
}
