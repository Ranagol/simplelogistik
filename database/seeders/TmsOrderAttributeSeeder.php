<?php

namespace Database\Seeders;

use App\Models\TmsOrderAttribute;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TmsOrderAttributeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TmsOrderAttribute::factory(config('constants.numberOfDbRecords'))->create();
    }
}
