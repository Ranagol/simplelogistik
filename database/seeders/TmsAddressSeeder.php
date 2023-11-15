<?php

namespace Database\Seeders;

use App\Models\TmsAddress;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TmsAddressSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TmsAddress::factory(config('constants.numberOfDbRecords'))->create();
    }
}
