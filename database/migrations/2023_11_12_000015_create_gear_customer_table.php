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
        Schema::create('gear_customer', function (Blueprint $table) {
            $table->foreignId('customer_id')->constrained('tms_customers');
            $table->foreignId('gear_id')->constrained('tms_gears');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gear_customer');
    }
};
