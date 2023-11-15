<?php

namespace Database\Seeders;

use App\Models\TmsContact;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TmsContactSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TmsContact::factory(config('constants.numberOfDbRecords'))->create();
    }
}
