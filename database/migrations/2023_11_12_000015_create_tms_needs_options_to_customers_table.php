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
        Schema::create('tms_needs_options_to_customers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('needsandoption_id');
            $table->foreign('needsandoption_id')->references('id')->on('tms_needsandoptions');
            $table->unsignedBigInteger('customer_id');
            $table->foreign('customer_id')->references('id')->on('tms_customers');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tms_needs_options_to_customers');
    }
};
