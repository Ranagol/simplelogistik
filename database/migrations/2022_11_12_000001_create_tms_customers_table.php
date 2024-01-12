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

            //Customer general info
            $table->bigIncrements('id');

            $table->unsignedBigInteger('forwarder_id')->nullable();
            $table->foreign('forwarder_id')->references('id')->on('tms_forwarders');

            $table->string('company_name',200)->nullable();
            $table->string('internal_id', 20);                   
            $table->string('first_name', 100);
            $table->string('last_name', 100);
            $table->string('email', 200)->nullable();
            $table->string('tax_number',200)->nullable();
            $table->integer('rating')->unsigned()->nullable();
            $table->json('comments')->nullable();//Note: we do not make this column in factory and faker. No need for that.
            $table->integer('payment_time')->comment('How many days the payment can be delayed. Example: 20 days means that the customer will pay after 20 days.')->unsigned()->nullable();

            //Individual customer data
            $table->boolean('auto_book_as_private')->nullable();
            $table->boolean('dangerous_goods')->nullable();
            $table->boolean('bussiness_customer')->nullable();
            $table->boolean('debt_collection')->nullable();
            $table->boolean('direct_debit')->nullable();
            $table->boolean('manual_collective_invoicing')->nullable();
            $table->boolean('private_customer')->nullable();
            $table->boolean('invoice_customer')->nullable();
            $table->boolean('poor_payment_morale')->nullable();
            $table->boolean('can_login')->default(true)->nullable();

            //Individual customer data - payment methods
            $table->boolean('paypal')->nullable();
            $table->boolean('sofort')->nullable();
            $table->boolean('amazon')->nullable();
            $table->boolean('vorkasse')->nullable();

            //These will work with mutators defined in model
            $table->integer('customer_type')->unsigned()->nullable();
            $table->integer('invoice_dispatch')->unsigned()->nullable();
            $table->integer('invoice_shipping_method')->unsigned()->nullable();
            $table->integer('payment_method')->unsigned()->nullable();

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
