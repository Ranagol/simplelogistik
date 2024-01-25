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
        Schema::create('tms_invoice_histories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('comment');
            $table->string('invoice_status');
            $table->decimal('additional_cost', 10, 2)->comment('These are the unplanned additinal cost of an invoice.')->nullable();
            $table->unsignedBigInteger('invoice_id');
            $table->foreign('invoice_id')->references('id')->on('tms_invoices');
            $table->unsignedBigInteger('forwarder_id');
            $table->foreign('forwarder_id')->references('id')->on('tms_forwarders');
            $table->unsignedBigInteger('customer_id');
            $table->foreign('customer_id')->references('id')->on('tms_customers');
            $table->unsignedBigInteger('forwarding_contract_id');
            $table->foreign('forwarding_contract_id')->references('id')->on('tms_forwarding_contracts');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tms_invoice_histories');
    }
};
