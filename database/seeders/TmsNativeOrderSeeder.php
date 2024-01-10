<?php

namespace Database\Seeders;

use App\Models\TmsNativeOrder;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TmsNativeOrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        /**
         * Here we create 10 sub-orders. Since we have 20 orders, we can use the order_id
         * to link the sub-orders to the orders. Only in this case. So, we have 20 orders.
         * But an order can't have both TmsNativeOrders and TmsPamyraOrders. It can have
         * only one of them. So, we have 10 orders with TmsNativeOrders and 10 orders with
         * TmsPamyraOrders. 
         * order_id's from 1 - 10: these will TmsNativeOrders
         * order_id's from 11 - 20: these will be TmsPamyraOrders
         */
        for ($i=1; $i <= config('constants.numberOfDbRecords')/2; $i++) { 
            TmsNativeOrder::factory()->create([
                'order_id' => $i,
            ]);
        }
    }
}
