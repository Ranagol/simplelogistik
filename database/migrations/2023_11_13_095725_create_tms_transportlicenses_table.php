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
        Schema::create('tms_transportlicenses', function (Blueprint $table) {
            $table->id();
            $table->string('license_number');
            $table->string('license_name');
            $table->date('license_valid_from');
            $table->date('license_valid_till');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tms_transportlicenses');
    }
};
