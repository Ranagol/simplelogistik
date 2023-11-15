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
        Schema::create('requirements_for_vehicles', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('vehicle_id');
            $table->foreign('vehicle_id')->references('id')->on('tms_vehicles');
            $table->unsignedBigInteger('requirement_for_vehicle_id');
            $table->foreign('requirement_for_vehicle_id')->references('id')->on('tms_requirements_for_vehicles');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('requirements_for_vehicles');
    }
};
