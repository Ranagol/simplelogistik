<?php

namespace Database\Seeders;

use App\Models\TmsCountry;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TmsCountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     * Data source for countries: https://www.iban.com/country-codes
     */
    public function run(): void
    {
        /**
         * The array of all countries is here: TmsCountry::COUNTRIES. We pull this array from the
         * db, and we loop thorugh this array. Every country in this array will be inserted into
         * the database.
         * This is actually our TmsCountryFactory, the actualy TmsCountryFactory is not used.
         */
        foreach (TmsCountry::COUNTRIES as $country) {
            DB::table('tms_countries')->updateOrInsert([
                'id' => (int)$country[3], // numeric_code is the id, because it is unique****
                'country_name' => $country[0],
                'alpha2_code' => $country[1],
                'alpha3_code' => $country[2],
                'numeric_code' => $country[3],
            ]);
        }
        
    }
}
