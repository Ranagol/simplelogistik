<?php

namespace Database\Seeders;

use App\Models\TmsForwarder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TmsForwarderSeeder extends Seeder
{
    /**
     * Create 1 forwarder with company name Emons and the rest 18 forwarders with random data.
     */
    public function run(): void
    {
        //Create Emons forwarder
        TmsForwarder::factory()->count(1)->create(
            [
                'company_name' => 'Emons',
                'slug' => 'emons.forwarder',
                'url_logo' => '/images/forwarder-logos/emons.svg',
            ]
        );

        //Create Timocom forwarder
        TmsForwarder::factory()->count(1)->create(
            [
                'company_name' => 'TimoCom',
                'slug' => 'timocom.forwarder',
                'url_logo' => '/images/forwarder-logos/timocom.svg',
            ]
        );

        //Create 18 random forwarders
        TmsForwarder::factory()->count(config('constants.numberOfDbRecords') - 2)->create();
    }
}
