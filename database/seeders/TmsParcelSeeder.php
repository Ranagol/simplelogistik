<?php

namespace Database\Seeders;

use App\Models\TmsParcel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TmsParcelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TmsParcel::factory(config('constants.numberOfDbRecords'))->create();
    }
}
