<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Pivot;
use App\Models\TmsParcel;
use App\Models\TmsAddress;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\TmsContact;
use App\Models\TmsCountry;
use App\Models\TmsInvoice;
use App\Models\TmsVehicle;
use App\Models\TmsCustomer;
use Illuminate\Support\Str;
use App\Models\TmsForwarder;
use App\Models\TmsOrder;
use App\Models\TmsDispatcher;
use App\Models\TmsGear;
use App\Models\TmsProvision;
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
use Database\Seeders\TmsDispatcherSeeder;
use Database\Seeders\TmsOfferPriceSeeder;
// use Database\Seeders\TmsVehicleReqSeeder;
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
            TmsCountrySeeder::class,
            TmsDispatcherSeeder::class,
            TmsCustomerSeeder::class,
            TmsForwarderSeeder::class,
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
            PivotTableSeeder::class,
            TmsParcelSeeder::class,
            TmsOrderAttributeSeeder::class,
            TmsProvisionSeeder::class,
        ]);

        // $dispatchers = TmsDispatcher::factory(5)->create();
        // echo "dispatchers created\n";
        // $customers = TmsCustomer::factory(20)->create();
        // echo "customers created\n";
        // $forwarders = TmsForwarder::factory(20)->create();
        // echo "forwarders created\n";
        // $requirements = TmsGear::factory(20)->create();
        // echo "requirements created\n";

        // $addressesCustomers = TmsAddress::factory()->count(4)->for($customers, 'address')->create();
        // echo "addressesCustomers created\n";
        // $addressesForwarders = TmsAddress::factory()->count(4)->for($forwarders, 'forwarder')->create();
        // echo "addressesForwarders created\n";

        // $contactsCustomers = TmsContact::factory()->count(2)->for($customers)->create();
        // echo "contactsCustomers created\n";
        // $contactsForwarders = TmsContact::factory()->count(2)->for($forwarders)->create();
        // echo "contactsForwarders created\n";

        // $vehicles = TmsVehicle::factory()->count(3)->for($forwarders)->create();//
        // echo "vehicles created\n";

        // $ordersCustomers = TmsOrder::factory()->count(2)->for($customers)->create();
        // echo "ordersCustomers created\n";
        // $ordersForwarders = TmsOrder::factory()->count(2)->for($forwarders)->create();
        // echo "ordersForwarders created\n";

        // $invoiceCustomers = TmsInvoice::factory()->count(1)->for($ordersCustomers)->create();
        // echo "invoiceCustomers created\n";
        // $invoiceForwarders = TmsInvoice::factory()->count(1)->for($ordersForwarders)->create();
        // echo "invoiceForwarders created\n";

        // $parcelsCustomerOrder = TmsParcel::factory()->count(2)->for($ordersCustomers)->create();
        // echo "parcelsCustomerOrder created\n";
        // $parcelsForwarderOrder = TmsParcel::factory()->count(2)->for($ordersForwarders)->create();
        // echo "parcelsForwarderOrder created\n";

    }
}

 