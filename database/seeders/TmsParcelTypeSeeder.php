<?php

namespace Database\Seeders;

use App\Models\TmsParcelType;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TmsParcelTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * getAllParcelTypes() returns a simple array of strings, which are the parcel types (names used
     * in Simplelogistik.
     */
    public function run(): void
    {
        $parcelTypes = TmsParcelType::getAllParcelTypes();

        foreach ($parcelTypes as $parcelType) {
            TmsParcelType::factory()->create(
                [
                    'description' => $parcelType
                ]
            );
        }
    }
}
