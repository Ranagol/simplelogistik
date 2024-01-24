<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Database\Seeders\TmsParcelSeeder;
use Database\Seeders\PivotTableSeeder;
use Database\Seeders\TmsAddressSeeder;
use Database\Seeders\TmsContactSeeder;
use Database\Seeders\TmsCountrySeeder;
use Database\Seeders\TmsInvoiceSeeder;
use Database\Seeders\TmsVehicleSeeder;
use Database\Seeders\TmsCustomerSeeder;
use Database\Seeders\TmsForwarderSeeder;
use Database\Seeders\TmsOrderSeeder;
use Database\Seeders\TmsOfferPriceSeeder;
use Database\Seeders\TmsGearSeeder;
use Database\Seeders\TmsOrderHistorySeeder;
use Database\Seeders\TmsOrderAttributeSeeder;
use Database\Seeders\TmsTransportLicenseSeeder;
use Database\Seeders\TmsForwardingContractSeeder;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        //This will create 20 users.
        User::factory(config('constants.numberOfDbRecords'))->create();

        /**
         * We need a test user for logging in to the application.
         * The test user credentials are stored in the .env file.
         * If there is no user with this given email, create it.
         */
        $testUsername = config('app.testUsername');
        $testPassword = config('app.testPassword');
        $testUser = User::where('name', '=', $testUsername)->get();
        
        if($testUser->isEmpty()){
            $testUser = User::factory()->create([
                'name' => $testUsername,
                'email' => $testUsername,
                'email_verified_at' => now(),
                'password' => Hash::make($testPassword),
                'remember_token' => Str::random(10),
            ]);
        }
        // Assign role to the test user
        $testUser->assignRole('admin');

        //Here starts the seeding process.
        $this->call([
            TmsRolesAndPermissionsSeeder::class,
            TmsCountrySeeder::class,
            TmsForwarderSeeder::class,
            TmsCustomerSeeder::class,
            TmsPartnerSeeder::class,
            TmsGearSeeder::class,
            TmsAddressSeeder::class,
            TmsContactSeeder::class,
            TmsVehicleSeeder::class,
            TmsOrderSeeder::class,
            TmsInvoiceSeeder::class,
            TmsOfferPriceSeeder::class,
            TmsForwardingContractSeeder::class,
            TmsOrderHistorySeeder::class,
            TmsTransportLicenseSeeder::class,
            //all pivot table connections are created in PivotTableSeeder, except Spatie stuff
            PivotTableSeeder::class,
            TmsParcelSeeder::class,
            TmsOrderAttributeSeeder::class,
            TmsProvisionSeeder::class,
            TmsPamyraOrderSeeder::class,
            TmsNativeOrderSeeder::class,
            TmsOrderAddressSeeder::class,
        ]);
    }
}

 