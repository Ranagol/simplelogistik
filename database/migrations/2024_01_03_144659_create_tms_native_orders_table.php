<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tms_native_orders', function (Blueprint $table) {
            //Basic order details
            $table->bigIncrements('id');
            $table->string('type_of_transport', 200)->comment('The type of transport. Example: LTL, FTL, Express, Air, Sea, Rail, Intermodal, Courier, Special')->nullable();
            $table->string('origin')->comment('The origin of the order. Example: Pamyra, Sales, Google Ads, Shipping ...')->nullable();
            $table->string('customer_reference')->comment('Customer reference. Example: when customer says please add this to the invoice.')->nullable();
            $table->decimal('provision', 10, 2)->comment('Example, for Pamyra orders the provision is 6%.')->nullable();
            $table->json('order_edited_events')->comment('When somebody edits the order, that must be registered here.')->nullable();//this does not need a factory/faker line
            $table->string('currency', 50)->comment('The currency of the order. Example: EUR, USD, GBP')->default('EUR');
            $table->date('order_date')->nullable();
            $table->string('purchase_price', 200)->comment('The purchase price of the order.')->nullable();
            $table->string('month_and_year')->comment('The month and year of the order. Example: 2021-01')->nullable();

            //Foreign keys
            $table->unsignedBigInteger('customer_id');
            $table->foreign('customer_id')->references('id')->on('tms_customers');
            $table->unsignedBigInteger('contact_id');
            $table->foreign('contact_id')->references('id')->on('tms_contacts')->comment('This is the contact person that is especially important, because this person has given us the official order. This is the reason why we keep this contact in the orders table.');

            //Addresses
            $table->unsignedBigInteger('pickup_address_id')->comment('The pickup address of the order. Selected from the customers addresses. Must be here.');
            $table->foreign('pickup_address_id')->references('id')->on('tms_addresses');
            $table->unsignedBigInteger('delivery_address_id')->comment('The delivery address of the order. Selected from the customers addresses. Must be here.');
            $table->foreign('delivery_address_id')->references('id')->on('tms_addresses');

            //Avis phone numbers. 
            $table->string('avis_customer_phone', 200)->comment('One time use customer phone number')->nullable();
            $table->string('avis_sender_phone', 200)->comment('One time use sender phone number')->nullable();
            $table->string('avis_receiver_phone', 200)->comment('One time use receiver phone number')->nullable();

            //Columns coming from Pamyra. All column from Pamyra must be prefixed with p_.
            $table->string('p_calculation_model_name')->comment('Name of the tariff')->nullable();
            $table->string('p_order_number')->nullable();
            $table->string('p_order_pdf')->nullable();
            $table->string('p_payment_method')->nullable();
            $table->string('p_date_of_sale')->nullable();
            $table->string('p_date_of_cancellation')->nullable();
            //Pickup time period details. Important: this is a time PERIOD. We adapted Pamyra stuff to our needs here.
            $table->dateTime('p_pickup_date_from')->comment('The pickup date AND time. Equal to Pamyra pickupDate.dateFrom + pickupDate.timeFromFrom')->nullable();
            $table->dateTime('p_pickup_date_to')->comment('The pickup date AND time. Equal to Pamyra pickupDate.dateTo + pickupDate.timeFromTo')->nullable();
            $table->string('p_pickup_comments')->comment('Equal to Pamyra pickupDate.asString. Special comments regarding pickup.')->nullable();
            //Delivery time period details. Important: this is a time PERIOD. We adapted Pamyra stuff to our needs here.
            $table->dateTime('p_delivery_date_from')->comment('The delivery date AND time. Equal to Pamyra deliveryDate.dateFrom + deliveryDate.timeFromFrom')->nullable();
            $table->dateTime('p_delivery_date_to')->comment('The delivery date AND time. Equal to Pamyra deliveryDate.dateTo + deliveryDate.timeFromTo')->nullable();
            $table->string('p_delivery_comments')->comment('Equal to Pamyra deliveryDate.asString. Special comments regarding delivery.')->nullable();
            $table->string('p_description_of_transport')->nullable();
            $table->string('p_particularities')->nullable();
            $table->string('p_loading_meter')->comment('Load meter of cargo')->nullable();
            $table->string('p_square_meter')->comment('Area of the cargo')->nullable();
            $table->string('p_total_weight')->comment('Weight of the cargo')->nullable();
            $table->string('p_qubic_meter')->comment('Volume of the cargo')->nullable();
            $table->string('p_calculated_transport_price')->nullable();
            $table->string('p_transport_price_gross')->nullable();
            $table->string('p_transport_price_vat')->nullable();
            $table->string('p_transport_price_net')->nullable();
            $table->string('p_customized_price_change')->nullable();
            $table->string('p_customized_price_mode')->nullable();
            $table->string('p_discount')->nullable();
            $table->string('p_price_gross')->nullable();
            $table->string('p_price_vat')->nullable();
            $table->string('p_price_net')->nullable();
            $table->string('p_price_fuel_surcharge')->nullable();
            $table->string('p_vat_rate')->nullable();
            $table->string('p_value_insured')->nullable();
            $table->string('p_value_of_goods')->nullable();
            $table->string('p_distance_km')->comment('Distance of the trip in km')->nullable();
            $table->string('p_duration_minutes')->comment('Travel time in min')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tms_native_orders');
    }
};
