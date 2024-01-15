<?php

namespace Database\Seeders;

use App\Models\TmsPartner;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TmsPartnerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        /**
         * Partner is for example Pamyra. There will be not too much of partners, so I fake only 3.
         */
        TmsPartner::factory(3)->create();
        
    }
}
