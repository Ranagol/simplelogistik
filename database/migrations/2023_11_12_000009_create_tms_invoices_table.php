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
            $table->unsignedBigInteger('cargo_order_id');
            $table->foreign('cargo_order_id')->references('id')->on('tms_cargo_orders');
            $table->unsignedBigInteger('customer_id');
            $table->foreign('customer_id')->references('id')->on('tms_customers');
            $table->unsignedBigInteger('forwarder_id');
            $table->foreign('forwarder_id')->references('id')->on('tms_forwarders');
            $table->string('invoice_number');
            $table->date('invoice_date');
            $table->date('invoice_received_date')->nullable();
            $table->string('currency', 50)->comment('The currency of the order. Example: EUR, USD, GBP')->default('EUR');
            $table->decimal('invoice_sum', 10,2);
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
