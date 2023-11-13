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
            $table->string('firstname');
            $table->string('secondname');
            $table->string('street', 200);
            $table->string('housenumber',200)->nullable();
            $table->string('zipcode',20);
            $table->string('city',100);
            $table->string('country',100);
            $table->string('state',100)->nullable();
            $table->string('type_of_address')->nullable();
            $table->string('comment',255)->nullable();
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
