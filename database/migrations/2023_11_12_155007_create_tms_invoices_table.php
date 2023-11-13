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
        Schema::create('tms_invoices', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('cargoorder_id');
            $table->foreign('cargoorder_id')->references('id')->on('tms_cargoorders');
            $table->unsignedBigInteger('customer_id');
            $table->foreign('customer_id')->references('id')->on('tms_customers');
            $table->unsignedBigInteger('forwarder_id');
            $table->foreign('forwarder_id')->references('id')->on('tms_forwarders');
            $table->string('invoicenumber');
            $table->dateTime('invoicedate');
            $table->string('currency');
            $table->decimal('invoicesum', 10,2);
            $table->decimal('tax',10,2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tms_invoices');
    }
};
