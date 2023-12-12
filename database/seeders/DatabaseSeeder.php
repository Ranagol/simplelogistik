<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Pivot;
use App\Models\TmsAddress;
use App\Models\TmsCountry;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\TmsCustomer;
use App\Models\TmsForwarder;
use App\Models\TmsOfferPrice;
use App\Models\TmsParcel;
use App\Models\TmsRequirement;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Database\Seeders\TmsAddressSeeder;
use Database\Seeders\TmsContactSeeder;
use Database\Seeders\TmsInvoiceSeeder;
use Database\Seeders\TmsVehicleSeeder;
use Database\Seeders\TmsCustomerSeeder;
use Database\Seeders\TmsForwarderSeeder;
use Database\Seeders\TmsCargoOrderSeeder;
use Database\Seeders\TmsDispatcherSeeder;
use Database\Seeders\TmsRequirementSeeder;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        
        User::factory(config('constants.numberOfDbRecords'))->create();

        /**
         * jedan@gmail.com is my test user. If there is no user with that email, create it.
         * The test user is used for logging in to the application.
         */
        $jedan = User::where('name', '=', 'jedan@gmail.com')->get();
        if($jedan->isEmpty()){
            User::factory()->create([
                'name' => 'jedan@gmail.com',
                'email' => 'jedan@gmail.com',
                'email_verified_at' => now(),
                'password' => Hash::make('jedan@gmail.com'),
                'remember_token' => Str::random(10),
            ]);
        }

        $this->call([
            TmsDispatcherSeeder::class,
            TmsCustomerSeeder::class,
            TmsForwarderSeeder::class,
            TmsRequirementSeeder::class,
            TmsAddressSeeder::class,
            TmsContactSeeder::class,
            TmsVehicleSeeder::class,
            TmsCargoOrderSeeder::class,
            TmsInvoiceSeeder::class,
            TmsOfferPriceSeeder::class,
            TmsForwardingContractSeeder::class,
            TmsCargoHistorySeeder::class,
            TmsRequirementForForwarderSeeder::class,
            TmsVehicleReqSeeder::class,
            TmsCustomerReqSeeder::class,
            TmsTransportLicenseSeeder::class,
            PivotTableSeeder::class,
            TmsParcelSeeder::class,
            TmsCountrySeeder::class,
            TmsOrderAttributeSeeder::class,
        ]);
    }
}
