<?php

namespace Database\Seeders;

use App\Models\TmsProvision;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TmsProvisionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (TmsProvision::PROVISIONS_FOR_SEEDINGS as $provision) {
            DB::statement($provision);
        }
    }
}
