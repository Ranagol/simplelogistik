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
        Schema::create('tms_order_addresses', function (Blueprint $table) {
            $table->id();

            //FOREIGN KEYS
            $table->unsignedBigInteger('customer_id')->nullable();
            $table->foreign('customer_id')->references('id')->on('tms_customers');
            $table->unsignedBigInteger('forwarder_id')->nullable();
            $table->foreign('forwarder_id')->references('id')->on('tms_forwarders');
            $table->unsignedBigInteger('country_id');//country
            $table->foreign('country_id')->references('id')->on('tms_countries');
            $table->unsignedBigInteger('partner_id')->nullable();
            $table->foreign('partner_id')->references('id')->on('tms_partners');

            $table->string('company_name', 255)->nullable();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('street', 200);
            $table->string('house_number',200)->nullable();
            $table->string('zip_code',20);
            $table->string('city',100);
            $table->string('state',100)->nullable();
            $table->string('address_additional_information',255)->comment('This is actually the comment part, but it is called address_additional_information in Pamyra. ')->nullable();
            $table->string('phone',100)->nullable();
            $table->string('email',100)->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tms_order_addresses');
    }
};
