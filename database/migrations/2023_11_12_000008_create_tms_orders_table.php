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
        Schema::create('tms_orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            
            //Foreign keys
            $table->unsignedBigInteger('customer_id');
            $table->foreign('customer_id')->references('id')->on('tms_customers');
            $table->unsignedBigInteger('contact_id')->nullable();
            $table->foreign('contact_id')->references('id')->on('tms_contacts')->comment('This is the contact person that is especially important, because this person has given us the official order. This is the reason why we keep this contact in the orders table.');
            $table->unsignedBigInteger('partner_id')->nullable();
            $table->foreign('partner_id')->references('id')->on('tms_partners');
            
            //Basic order details
            $table->string('type_of_transport', 200)->comment('The type of transport. Example: LTL, FTL, Express, Air, Sea, Rail, Intermodal, Courier, Special')->default('parcel');
            $table->string('origin')->comment('The origin of the order. Example: Pamyra, Sales, Google Ads, Shipping ...')->nullable();
            $table->string('customer_reference')->comment('Customer reference. Example: when customer says please add this to the invoice, we wish to have this addtional info on our invoice.')->nullable();
            $table->decimal('provision', 10, 2)->comment('The calculated value of the provision, in eur. Not in percentage!')->nullable();
            $table->json('order_edited_events')->comment('When somebody edits the order, that must be registered here.')->nullable();//this does not need a factory/faker line
            $table->string('currency', 50)->comment('The currency of the order. Example: EUR, USD, GBP')->default('EUR');
            $table->date('order_date')->nullable();
            $table->string('purchase_price', 200)->comment('The purchase price of the order.');
            $table->string('month_and_year')->comment('The month and year of the order, but in full date format.')->nullable();

            //Avis phone numbers. 
            $table->string('avis_customer_phone', 200)->comment('One time use customer phone number')->nullable();
            $table->string('avis_sender_phone', 200)->comment('One time use sender phone number')->nullable();
            $table->string('avis_receiver_phone', 200)->comment('One time use receiver phone number')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tms_orders');
    }
};
