<?php

namespace Database\Seeders;

use App\Models\TmsDispatcher;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TmsDispatcherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TmsDispatcher::factory()->count(config('constants.numberOfDbRecords'))->create();
    }
}
