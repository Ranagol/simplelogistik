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
        Schema::create('order_order_attribute', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('tms_orders');
            $table->foreignId('order_attribute_id')->constrained('tms_order_attributes');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_order_attribute');
    }
};
