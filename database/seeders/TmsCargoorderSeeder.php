<?php

namespace Database\Seeders;

use App\Models\TmsCargoOrder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TmsCargoOrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TmsCargoOrder::factory(config('constants.numberOfDbRecords'))->create();
    }
}
