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
        Schema::create('tms_vehicles', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('forwarder_id')->nullable();
            $table->foreign('forwarder_id')->references('id')->on('tms_forwarders');
            $table->unsignedBigInteger('address_id')->nullable();
            $table->foreign('address_id')->references('id')->on('tms_addresses');
            
            $table->string('name', 100)->nullable();
            $table->decimal('max_weight', 10,2)->nullable();
            $table->decimal('max_pickup_weight',10,2)->nullable();
            $table->decimal('max_pickup_width',10,2)->nullable();
            $table->decimal('max_pickup_height',10,2)->nullable();
            $table->decimal('max_pickup_length',10,2)->nullable();
            $table->string('vehicle_type', 100)->nullable();
            $table->string('plate_number', 50)->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tms_vehicles');
    }
};
