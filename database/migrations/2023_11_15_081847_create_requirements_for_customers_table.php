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
        Schema::create('requirements_for_customers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('customer_id');
            $table->foreign('customer_id')->references('id')->on('tms_customers');
            $table->unsignedBigInteger('requirement_for_customer_id');
            $table->foreign('requirement_for_customer_id')->references('id')->on('tms_requirements_for_customers');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('requirements_for_customers');
    }
};
