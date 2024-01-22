<?php

namespace Database\Seeders;

use App\Models\TmsProvision;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TmsProvisionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        /**
         * During seeding, we only create 1 provision record, which will be always customer nr. 1.
         */
        TmsProvision::factory(1)->create();
    }
}
