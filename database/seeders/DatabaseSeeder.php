<?php

namespace Database\Seeders;

use App\Models\TmsInvoice;
use App\Models\TmsOrder;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
        
        //Here starts the seeding process.
        $this->call([
            TmsRolesAndPermissionsSeeder::class,
            UserSeeder::class,
            TmsCountrySeeder::class,
            // TmsForwarderSeeder::class,
            // TmsCustomerSeeder::class,
            TmsPartnerSeeder::class,
            TmsPaymentMethodSeeder::class,
            TmsGearSeeder::class,
            // TmsAddressSeeder::class,
            // TmsContactSeeder::class,
            // TmsVehicleSeeder::class,
            TmsOrderStatusSeeder::class,
            // TmsOrderSeeder::class,
            TmsInvoiceStatusSeeder::class,
            // TmsInvoiceSeeder::class,
            // TmsOfferPriceSeeder::class,
            // TmsForwardingContractSeeder::class,
            // TmsOrderHistorySeeder::class,
            // TmsTransportLicenseSeeder::class,
            // TmsParcelSeeder::class,
            TmsOrderAttributeSeeder::class,
            //all pivot table connections are created in PivotTableSeeder, except Spatie stuff
            PivotTableSeeder::class,
            TmsProvisionSeeder::class,
            // TmsPamyraOrderSeeder::class,
            // TmsNativeOrderSeeder::class,
            // TmsOrderAddressSeeder::class,
            // TmsInvoiceHistorySeeder::class,
            // TmsEmonsInvoiceSeeder::class,
            TmsFtpCredentialSeeder::class,
            TmsTransportRuleSeeder::class,
        ]);
    }
}

 