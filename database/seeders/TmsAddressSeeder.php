<?php

namespace Database\Seeders;

use App\Models\TmsAddress;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TmsAddressSeeder extends Seeder
{
    /**
     * TmsAddress has also address types, just like TmsOrderAddress. But the address types are different.
     * TmsAddress has 4 boolean address types columns in db.
     * TmsOrderAddress has addressType as one string column, with mutator
     *
     * @var array
     */
    protected array $booleanAddressTypes = [
        'is_pickup',
        'is_delivery',
        'is_billing',
        'is_headquarter',
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
        foreach ($this->booleanAddressTypes as $key => $booleanAddressType) {

            /**
             * Usually we have 20 customers created by the seeder. 
             */
            for ($i=1; $i <= config('constants.numberOfDbRecords'); $i++) { 
                TmsAddress::factory()->create([
                    /**
                     * Here we explicitly define the value of the the customer_id.
                     * All other columns will be defined by the  factory faker.
                     */
                    $booleanAddressType => true,
                    'customer_id' => $i,
                    'forwarder_id' => $i,
                    // partner_id is defined in the factory
                ]);
            }
        }
    }
}




