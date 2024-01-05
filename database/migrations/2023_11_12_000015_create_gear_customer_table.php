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
        Schema::create('tms_needed_gears', function (Blueprint $table) {
            $table->foreignId('tms_customer_id')->constrained('tms_customers');
            $table->foreignId('tms_listed_gear_id')->constrained('tms_gears');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tms_needed_gears');
    }
};
