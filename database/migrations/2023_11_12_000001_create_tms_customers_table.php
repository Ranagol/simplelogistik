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
        Schema::create('tms_customers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('internal_cid', 20);                           // e.g.  C000 0007 1093 0276 0123 4567 89AB CDEF
            $table->string('name', 100);
            $table->string('email', 200);
            $table->string('company_name',200)->nullable();
            $table->string('tax_number',200)->nullable();
            $table->integer('rating')->unsigned()->nullable();

            $table->boolean('auto_book_as_private')->nullable();
            $table->boolean('dangerous_goods')->nullable();
            $table->boolean('bussiness_customer')->nullable();
            $table->boolean('debt_collection')->nullable();
            $table->boolean('direct_debit')->nullable();
            $table->boolean('manual_collective_invoicing')->nullable();
            $table->boolean('only_paypal_sofort_amazon_vorkasse')->nullable();
            $table->boolean('private_customer')->nullable();
            $table->boolean('invoice_customer')->nullable();
            $table->boolean('poor_payment_morale')->nullable();
            $table->boolean('can_login')->default(true)->nullable();
            
            $table->unsignedBigInteger('tms_invoice_dispatch_id');
            $table->foreign('tms_invoice_dispatch_id')->references('id')->on('tms_invoice_dispatches');
            $table->unsignedBigInteger('tms_invoice_shipping_method_id');
            $table->foreign('tms_invoice_shipping_method_id')->references('id')->on('tms_invoice_shipping_methods');
            $table->unsignedBigInteger('tms_payment_method_id');
            $table->foreign('tms_payment_method_id')->references('id')->on('tms_payment_methods');

            $table->softDeletes($column = 'deleted_at', $precision = 0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tms_customers');
    }
};
