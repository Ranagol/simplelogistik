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
        // ORDERS TABLE
        Schema::create('tms_cargo_orders', function (Blueprint $table) {

            //Basic order details
            $table->bigIncrements('id');
            $table->string('order_number', 200);
            $table->string('description', 255);
            $table->string('type_of_transport', 200)->comment('The type of transport. Example: LTL, FTL, Express, Air, Sea, Rail, Intermodal, Courier, Special')->nullable();
            $table->string('origin')->comment('The origin of the order. Example: Pamyra, Sales, Google Ads, Shipping ...')->nullable();
            $table->string('customer_reference')->comment('Customer reference. Example: when customer says please add this to the invoice.')->nullable();
            $table->decimal('shipping_price', 10, 2);
            $table->decimal('shipping_price_netto', 10, 2);
            $table->json('order_edited_events')->comment('When somebody edits the order, that must be registered here.')->nullable();//this does not need a factory/faker line

            //Foreign keys
            $table->unsignedBigInteger('customer_id');
            $table->foreign('customer_id')->references('id')->on('tms_customers');
            $table->unsignedBigInteger('contact_id');
            $table->foreign('contact_id')->references('id')->on('tms_contacts');

            //Addresses
            $table->unsignedBigInteger('pickup_address_id');
            $table->foreign('pickup_address_id')->references('id')->on('tms_addresses');
            $table->unsignedBigInteger('delivery_address_id');//change to delivery
            $table->foreign('delivery_address_id')->references('id')->on('tms_addresses');

            //Avis phone numbers. 
            $table->string('avis_customer_phone', 200)->comment('One time use customer phone number')->nullable();
            $table->string('avis_sender_phone', 200)->comment('One time use sender phone number')->nullable();
            $table->string('avis_receiver_phone', 200)->comment('One time use receiver phone number')->nullable();

            //Pickup time period details. Important: this is a time PERIOD.
            $table->dateTime('pickup_date_from')->comment('The pickup date AND time. Equal to Pamyra pickupDate.dateFrom + pickupDate.timeFromFrom')->nullable();
            $table->dateTime('pickup_date_to')->comment('The pickup date AND time. Equal to Pamyra pickupDate.dateTo + pickupDate.timeFromTo')->nullable();
            $table->string('pickup_comments')->comment('Equal to Pamyra pickupDate.asString. Special comments regarding pickup.')->nullable();

            //Delivery time period details. Important: this is a time PERIOD.
            $table->dateTime('delivery_date_from')->comment('The delivery date AND time. Equal to Pamyra deliveryDate.dateFrom + deliveryDate.timeFromFrom')->nullable();
            $table->dateTime('delivery_date_to')->comment('The delivery date AND time. Equal to Pamyra deliveryDate.dateTo + deliveryDate.timeFromTo')->nullable();
            $table->string('delivery_comments')->comment('Equal to Pamyra deliveryDate.asString. Special comments regarding delivery.')->nullable();

            




            //these are additional, so far non-existing but needed columns*************************
            

            

            //origin column must be added. (Pamyra, sales, Google Ads, Shipping ... something)

            //F. said origin_order_is is needed.Connected to the origin_order column. 

            //provision column. Example, for Pamyra orders the provision is 6%.

            //customer_reference column. Example: when customer says please add this to the invoice.

            //





            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tms_cargo_orders');
    }
};
