<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Order attribute is a service that the customer can order, and must pay. Example: SMS notification 
 * after the final delivery. This is an order attribute. 
 */
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tms_order_attributes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tms_cargo_order_id')->comment('An attribute always belongs to a cargo order.');
            $table->foreign('tms_cargo_order_id')->references('id')->on('tms_orders');
            $table->string('type', 200)->comment('Example: customer chooses extra service, like sms notification when package is delivered. This has additional cost.')->nullable();
            $table->decimal('price', 10, 2)->comment('The price of the attribute/extra service. We must have a price and currency column here, because every order attribute is actually an additional service that the customer can order, and must pay. Example: SMS notification after the final delivery. For this the customer must pay.')->nullable();
            $table->string('currency', 50)->comment('The currency of the order. Example: EUR, USD, GBP.  We must have a price and currency column here, because every order attribute is actually an additional service that the customer can order, and must pay. Example: SMS notification after the final delivery. For this the customer must pay.')->default('EUR');
            $table->string('description', 255)->comment('This is a description column')->nullable();
            $table->date('from_date')->comment('The date from which the order attribute price is valid.')->nullable();
            $table->date('to_date')->comment('The date until which the order attribute price is valid.')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tms_order_attributes');
    }
};
