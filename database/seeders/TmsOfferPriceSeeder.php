<?php

namespace Database\Seeders;

use App\Models\TmsOfferPrice;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TmsOfferPriceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TmsOfferPrice::factory(config('constants.numberOfDbRecords'))->create();
    }
}
