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
        Schema::create('tms_vehicle_reqs', function (Blueprint $table) {
            $table->foreignId('tms_vehicle_id')->constrained('tms_vehicles');
            $table->foreignId('tms_listed_gear_id')->constrained('tms_gears');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tms_vehicle_reqs');
    }
};
