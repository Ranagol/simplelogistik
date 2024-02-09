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
        Schema::create('tms_payment_methods', function (Blueprint $table) {
            $table->id();
            $table->string('internal_name')->comment('The name of the payment method in our system');
            $table->string('external_name')->comment('The name of the payment method in the external system');
            $table->unsignedBigInteger('partner_id')->comment('The id of the partner that offers this payment method');
            $table->foreign('partner_id')->references('id')->on('tms_partners');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tms_payment_methods');
    }
};
