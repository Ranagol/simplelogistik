<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TmsFtpConnectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pamyraOrdersTest = env('PAMYRA_ORDERS_TEST');
        if ($pamyraOrdersTest !== null) {
            DB::statement($pamyraOrdersTest);
        }

        $pamyraOrdersLive = env('PAMYRA_ORDERS_LIVE');
        if ($pamyraOrdersLive !== null) {
            DB::statement($pamyraOrdersLive);
        }
    }
}
