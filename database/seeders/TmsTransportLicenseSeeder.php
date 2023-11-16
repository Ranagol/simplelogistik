<?php

namespace Database\Seeders;

use App\Models\TmsTransportLicense;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TmsTransportLicenseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TmsTransportLicense::factory(config('constants.numberOfDbRecords'))->create();
    }
}
