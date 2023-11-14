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
        Schema::create('tms_needs_options_to_vehicles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('needsandoption_id');
            $table->foreign('needsandoption_id')->references('id')->on('tms_needsandoptions');
            $table->unsignedBigInteger('vehicle_id');
            $table->foreign('vehicle_id')->references('id')->on('tms_vehicles');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tms_needs_options_to_vehicles');
    }
};
