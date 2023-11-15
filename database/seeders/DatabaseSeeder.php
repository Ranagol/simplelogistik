<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\TmsAddress;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\TmsCustomer;
use App\Models\TmsForwarder;
use App\Models\TmsOfferPrice;
use App\Models\TmsRequirements;
use Illuminate\Database\Seeder;
use Database\Seeders\TmsAddressSeeder;
use Database\Seeders\TmsContactSeeder;
use Database\Seeders\TmsInvoiceSeeder;
use Database\Seeders\TmsVehicleSeeder;
use Database\Seeders\TmsCustomerSeeder;
use Database\Seeders\TmsForwarderSeeder;
use Database\Seeders\TmsCargoOrderSeeder;
use Database\Seeders\TmsDispatcherSeeder;
use Database\Seeders\TmsRequirementsSeeder;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        /**
         * jedan@gmail.com is my test user. If there is no user with that email, create it.
         * And, I also need 9 more users. The test user is used for logging in.
         */
        $jedan = User::where('name', '=', 'jedan@gmail.com')->get();
        if(!$jedan){
            User::factory()->create([
                'name' => 'jedan@gmail.com',
                'email' => 'jedan@gmail.com',
            ]);
        }
        User::factory(config('constants.numberOfDbRecords'))->create();

        $this->call([
            TmsDispatcherSeeder::class,
            TmsCustomerSeeder::class,
            TmsForwarderSeeder::class,
            TmsRequirementsSeeder::class,
            TmsAddressSeeder::class,
            TmsContactSeeder::class,
            TmsVehicleSeeder::class,
            TmsCargoOrderSeeder::class,
            TmsInvoiceSeeder::class,
            TmsOfferPriceSeeder::class,
            TmsForwardingContractSeeder::class,
        ]);



    }
}
