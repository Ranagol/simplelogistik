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
        Schema::create('gear_vehicle', function (Blueprint $table) {
            $table->foreignId('vehicle_id')->constrained('tms_vehicles');
            $table->foreignId('gear_id')->constrained('tms_gears');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gear_vehicle');
    }
};
