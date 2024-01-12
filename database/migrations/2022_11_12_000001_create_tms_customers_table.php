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

            /**
             * Individual customer data - special settings
             * When creating a new customer, all unchecked checkboxes will be in Vue simply null,
             * untill they are at least once checked or unchecked. After that, they are either true 
             * or false. To avoid issues with unchcked checkboxes, we set them all to false
             * (some of them true) by default, in the migration. Together with this, in the
             * customer validation we allow null values for these checkboxes.
             */
            $table->boolean('auto_book_as_private')->default(false);
            $table->boolean('dangerous_goods')->default(false);
            $table->boolean('bussiness_customer')->default(false);
            $table->boolean('debt_collection')->default(false);
            $table->boolean('direct_debit')->default(false);
            $table->boolean('manual_collective_invoicing')->default(false);
            $table->boolean('private_customer')->default(false);
            $table->boolean('invoice_customer')->default(false);
            $table->boolean('poor_payment_morale')->default(false);
            $table->boolean('can_login')->default(true);

            //Individual customer data - payment methods
            $table->boolean('paypal')->default(false);
            $table->boolean('sofort')->default(false);
            $table->boolean('amazon')->default(false);
            $table->boolean('vorkasse')->default(false);

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
