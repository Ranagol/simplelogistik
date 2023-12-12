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

            //these are done by default
            $table->bigIncrements('id');
            $table->string('internal_oid', 200);

            $table->unsignedBigInteger('customer_id');
            $table->foreign('customer_id')->references('id')->on('tms_customers');
            $table->unsignedBigInteger('contact_id');
            $table->foreign('contact_id')->references('id')->on('tms_contacts');

            //Addresses
            $table->unsignedBigInteger('pickup_address_id');
            $table->foreign('pickup_address_id')->references('id')->on('tms_addresses');
            $table->unsignedBigInteger('delivery_address_id');//change to delivery
            $table->foreign('delivery_address_id')->references('id')->on('tms_addresses');

            $table->string('description', 255);
            $table->decimal('shipping_price', 10, 2);
            $table->decimal('shipping_price_netto', 10, 2);

            $table->string('avis_customer_phone', 200)->comment('One time use customer phone number')->nullable();
            $table->string('avis_sender_phone', 200)->comment('One time use sender phone number')->nullable();
            $table->string('avis_receiver_phone', 200)->comment('One time use receiver phone number')->nullable();

            // $table->string('pickup_date')->nullable();
            // $table->string('delivery_date')->nullable();

            //Pickup time details
            







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
