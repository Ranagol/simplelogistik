<?php

namespace Database\Seeders;

use App\Models\TmsTransportRule;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TmsTransportRuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (TmsTransportRule::TRANSPORT_RULES as $rule) {
            DB::statement($rule);
        }
    }
}
