<?php

namespace Database\Seeders;

use App\Models\TmsAddress;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TmsAddressSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        /**
         * Currently, there are 4 address types in the database. For every address type, we want to
         * create 20 addresses.
         */
        foreach (TmsAddress::ADDRESS_TYPES as $addressType) {
            TmsAddress::factory(config('constants.numberOfDbRecords'))->create([
                'address_type' => $addressType
            ]);
        }
    }
}




