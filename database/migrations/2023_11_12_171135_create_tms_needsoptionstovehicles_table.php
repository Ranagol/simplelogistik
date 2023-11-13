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
        Schema::create('tms_needsoptionstovehicles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('needsandoption_id');
            $table->unsignedBigInteger('vehicle_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tms_needsoptionstovehicles');
    }
};
