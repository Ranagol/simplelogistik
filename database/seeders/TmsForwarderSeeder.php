<?php

namespace Database\Seeders;

use App\Models\TmsForwarder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TmsForwarderSeeder extends Seeder
{
    /**
     * Create 1 forwarder with company name Emons and the rest 19 forwarders with random data.
     */
    public function run(): void
    {
        TmsForwarder::factory()->count(1)->create(
            [
                'company_name' => 'Emons',
            ]
        );
        TmsForwarder::factory()->count(config('constants.numberOfDbRecords') - 1)->create();
    }
}
