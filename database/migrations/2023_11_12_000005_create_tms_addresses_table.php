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
        Schema::create('tms_addresses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('company_name', 255)->nullable();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->integer('address_type')->comment('See TmsAddress model, ADDRESS_TYPE constant for additional info.')->unsigned()->nullable();
            $table->string('street', 200);
            $table->string('house_number',200)->nullable();
            $table->string('zip_code',20);
            $table->string('city',100);
            $table->string('state',100)->nullable();
            $table->string('address_additional_information',255)->comment('This is actually the comment part, but it is calledaddress_additional_information in Pamyra. ')->nullable();
            
            
            $table->unsignedBigInteger('country_id');//country
            $table->foreign('country_id')->references('id')->on('tms_countries');


            $table->unsignedBigInteger('customer_id')->nullable();
            $table->foreign('customer_id')->references('id')->on('tms_customers');
            $table->unsignedBigInteger('forwarder_id')->nullable();
            $table->foreign('forwarder_id')->references('id')->on('tms_forwarders');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tms_addresses');
    }
};
