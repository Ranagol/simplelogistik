<?php

namespace Database\Seeders;

use App\Models\TmsEmonsInvoice;
use App\Models\TmsOrder;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TmsEmonsInvoiceSeeder extends Seeder
{


    /**
     * Run the database seeds.
     * Here we want to create a TmsEmonsInvoice for each TmsOrder. It is important that we use alredy
     * existing order numbers, because we want to have a relation between the TmsOrder and the 
     * TmsEmonsInvoice.
     */
    public function run(): void
    {
        $orderNumbers = TmsOrder::pluck('order_number')->toArray();
        foreach ($orderNumbers as $orderNumber) {
            TmsEmonsInvoice::factory()->create([
                'order_number' => $orderNumber
            ]);
        }
    }
}
