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
        foreach (TmsTransportRule::TRANSPORT_RULE_ARRAYS as $rule) {
            TmsTransportRule::create($rule);
        }
    }
}
