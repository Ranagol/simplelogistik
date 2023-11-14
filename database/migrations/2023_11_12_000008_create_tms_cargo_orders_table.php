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
        Schema::create('tms_cargo_orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('internaloid', 200);                           // e.g.  0000-0007-1093-0276-92bc4f1a-8180-11ee-b962-0242ac120002
            $table->unsignedBigInteger('customer_id');
            $table->foreign('customer_id')->references('id')->on('tms_customers');
            $table->unsignedBigInteger('contact_id');
            $table->foreign('contact_id')->references('id')->on('tms_contacts');
            $table->unsignedBigInteger('startaddress_id');
            $table->foreign('startaddress_id')->references('id')->on('tms_addresses');
            $table->unsignedBigInteger('targetaddress_id');
            $table->foreign('targetaddress_id')->references('id')->on('tms_addresses');
            $table->string('description', 255);
            $table->decimal('shippingprice', 10, 2);
            $table->decimal('shippingpricenetto', 10, 2);
            $table->dateTime('pickupdate')->nullable();
            $table->dateTime('deliverydate')->nullable();
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
