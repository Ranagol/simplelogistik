<?php

namespace Database\Seeders;

use App\Models\TmsOrderStatus;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TmsOrderStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $statuses = TmsOrderStatus::STATUSES;
        // foreach ($statuses as $status) {
        //     TmsOrderStatus::factory()->create([
        //         'internal_name' => $status['internal_name'],
        //         'external_name' => $status['external_name'],
        //     ]);
        // }
    }
}
