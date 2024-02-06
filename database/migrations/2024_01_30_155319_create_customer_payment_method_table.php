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
        Schema::create('customer_payment_method', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained('tms_customers');
            $table->foreignId('payment_method_id')->constrained('tms_payment_methods');
            $table->boolean('is_active')->comment('Is this payment method active for this customer?');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_payment_method');
    }
};
