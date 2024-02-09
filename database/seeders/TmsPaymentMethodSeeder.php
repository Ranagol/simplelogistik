<?php

namespace Database\Seeders;

use App\Models\TmsPartner;
use Illuminate\Database\Seeder;
use App\Models\TmsPaymentMethod;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TmsPaymentMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $paymentMethods = TmsPaymentMethod::PAYMENT_METHODS;

        foreach ($paymentMethods as $paymentMethod) {
            TmsPaymentMethod::factory()->create([
                'internal_name' => $paymentMethod['internal_name'],
                'external_name' => $paymentMethod['external_name'],
            ]);
        }
    }
}
