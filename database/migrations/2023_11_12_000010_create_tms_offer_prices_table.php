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
        Schema::create('tms_offer_prices', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('description', 255);
            $table->dateTime('offer_from')->nullable();
            $table->dateTime('offer_to')->nullable();
            $table->unsignedBigInteger('forwarder_id');
            $table->foreign('forwarder_id')->references('id')->on('tms_forwarders');
            $table->unsignedBigInteger('order_id')->nullable();
            $table->foreign('order_id')->references('id')->on('tms_orders');
            $table->decimal('offered_price',10,2);
            $table->decimal('offered_price_net',10,2)->nullable();
            $table->string('currency', 50)->comment('The currency of the order. Example: EUR, USD, GBP')->default('EUR');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tms_offer_prices');
    }
};
