<?php

namespace Database\Seeders;

use App\Models\TmsPaymentMethod;
use Faker\Provider\ar_EG\Payment;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TmsPaymentMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TmsPaymentMethod::factory()->count(4)->create();
    }
}
