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
        Schema::create('gear_forwarder', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('forwarder_id')->constrained('tms_forwarders');
            $table->foreignId('gear_id')->constrained('tms_gears');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gear_forwarder');
    }
};
