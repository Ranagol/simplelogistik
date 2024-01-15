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
         * constants.numberOfDbRecords is a constant. It should be 20. It means that in a general case
         * we want 20 customers created, 20 orders created... so on, in the db. In general case.
         * But in this specific case, we want 40 addresses. Therefore we multiply the constant by 2.
         */
        for ($i=1; $i <= config('constants.numberOfDbRecords') * 2; $i++) { 
            TmsAddress::factory()->create([
                /**
                 * Here we explicitly define the value of the the customer_id.
                 * All other columns will be defined by the  factory faker.
                 */
                'customer_id' => $i,
                'forwarder_id' => $i,
                // partner_id is defined in the factory
            ]);
        }
    }
}




