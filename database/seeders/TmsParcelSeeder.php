<?php

namespace Database\Seeders;

use App\Models\TmsParcel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TmsParcelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * For every order we create two parcels.
     */
    public function run(): void
    {
        // TmsParcel::factory(config('constants.numberOfDbRecords'))->create();
        for ($i=1; $i <= config('constants.numberOfDbRecords'); $i++) { 
            TmsParcel::factory()->create([
                'order_id' => $i,
            ]);
            TmsParcel::factory()->create([
                'order_id' => $i,
            ]);
        }

    }
}
