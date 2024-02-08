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
        Schema::create('tms_pamyra_orders', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('order_id');
            $table->foreign('order_id')->references('id')->on('tms_orders');

            $table->string('calculation_model_name')->comment('Name of the tariff')->nullable();
            $table->string('order_number')->nullable();
            $table->text('order_pdf')->nullable();
            $table->string('payment_method')->nullable();
            $table->string('date_of_sale')->nullable();
            $table->string('date_of_cancellation')->nullable();
            //Pickup time period details. Important: this is a time PERIOD. We adapted Pamyra stuff to our needs here.
            $table->dateTime('pickup_date_from')->comment('The pickup date AND time. Equal to Pamyra pickupDate.dateFrom + pickupDate.timeFromFrom')->nullable();
            $table->dateTime('pickup_date_to')->comment('The pickup date AND time. Equal to Pamyra pickupDate.dateTo + pickupDate.timeFromTo')->nullable();
            $table->string('pickup_comments')->comment('Equal to Pamyra pickupDate.asString. Special comments regarding pickup.')->nullable();
            //Delivery time period details. Important: this is a time PERIOD. We adapted Pamyra stuff to our needs here.
            $table->dateTime('delivery_date_from')->comment('The delivery date AND time. Equal to Pamyra deliveryDate.dateFrom + deliveryDate.timeFromFrom')->nullable();
            $table->dateTime('delivery_date_to')->comment('The delivery date AND time. Equal to Pamyra deliveryDate.dateTo + deliveryDate.timeFromTo')->nullable();
            $table->string('delivery_comments')->comment('Equal to Pamyra deliveryDate.asString. Special comments regarding delivery.')->nullable();
            $table->string('description_of_transport')->nullable();
            $table->string('particularities')->nullable();
            $table->string('loading_meter')->comment('Load meter of cargo')->nullable();
            $table->string('square_meter')->comment('Area of the cargo')->nullable();
            $table->string('total_weight')->comment('Weight of the cargo')->nullable();
            $table->string('qubic_meter')->comment('Volume of the cargo')->nullable();
            $table->string('calculated_transport_price')->nullable();
            $table->string('transport_price_gross')->nullable();
            $table->string('transport_price_vat')->nullable();
            $table->string('transport_price_net')->nullable();
            $table->string('customized_price_change')->nullable();
            $table->string('customized_price_mode')->nullable();
            $table->string('discount')->nullable();
            $table->string('price_gross')->nullable();
            $table->string('price_vat')->nullable();
            $table->string('price_net')->nullable();
            $table->string('price_fuel_surcharge')->nullable();
            $table->string('vat_rate')->nullable();
            $table->string('value_insured')->nullable();
            $table->string('value_of_goods')->nullable();
            $table->string('distance_km')->comment('Distance of the trip in km')->nullable();
            $table->string('duration_minutes')->comment('Travel time in min')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tms_pamyra_orders');
    }
};
