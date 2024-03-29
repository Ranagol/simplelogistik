<?php

namespace Database\Factories;

use App\Models\TmsCustomer;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Tms_customer>
 */
class TmsCustomerFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = TmsCustomer::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'internal_id' => $this->faker->unique()->numberBetween(10000, 99999),
            'forwarder_id' => $this->faker->randomElement([null, null, null, null, null, null, 1]),
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'email' => $this->faker->unique()->safeEmail,
            'phone' => $this->faker->phoneNumber,
            'company_name' => $this->faker->company,
            'tax_number' => $this->faker->unique()->randomNumber(9, true),
            'rating' => $this->faker->numberBetween(1, 5),
            'payment_time' => $this->faker->numberBetween(1, 30),
            'auto_book_as_private' => $this->faker->boolean,
            'dangerous_goods' => $this->faker->boolean,
            'bussiness_customer' => $this->faker->boolean,
            'debt_collection' => $this->faker->boolean,
            'direct_debit' => $this->faker->boolean,
            'manual_collective_invoicing' => $this->faker->boolean,
            'private_customer' => $this->faker->boolean,
            'invoice_customer' => $this->faker->boolean,
            'poor_payment_morale' => $this->faker->boolean,
            'can_login' => $this->faker->boolean,
            'payment_method_options_to_offer' => ["Vorkasse", "Invoice"],
            'email_for_invoice' => $this->faker->unique()->safeEmail,
            'email_for_label' => $this->faker->unique()->safeEmail,
            'email_for_pod' => $this->faker->unique()->safeEmail,
            'customer_reference' => $this->faker->unique()->word,
            'customer_type' => $this->faker->numberBetween(1, count(TmsCustomer::CUSTOMER_TYPES) - 1),
            'invoice_dispatch' => $this->faker->numberBetween(1, count(TmsCustomer::INVOICE_DISPATCHES) - 1),
            'invoice_shipping_method' => $this->faker->numberBetween(1, count(TmsCustomer::INVOICE_SHIPPING_METHODS) - 1),
        ];
    }
}

