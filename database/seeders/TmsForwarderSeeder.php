<?php

namespace Database\Seeders;

use App\Models\TmsForwarder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TmsForwarderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TmsForwarder::factory()->count(config('constants.numberOfDbRecords'))->create();
    }
}
