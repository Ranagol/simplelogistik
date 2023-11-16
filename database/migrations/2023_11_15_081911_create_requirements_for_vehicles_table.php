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
            $table->foreignId('tms_vehicle_id')->constrained('tms_vehicles');
            $table->foreignId('tms_vehicle_req_id')->constrained('tms_vehicle_reqs');
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
