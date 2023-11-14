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
        Schema::create('tms_forwarding_processes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('comment');
            $table->unsignedBigInteger('forwarder_id');
            $table->foreign('forwarder_id')->references('id')->on('tms_forwarders');
            $table->unsignedBigInteger('customer_id');
            $table->foreign('customer_id')->references('id')->on('tms_customers');
            $table->unsignedBigInteger('cargoorder_id');
            $table->foreign('cargoorder_id')->references('id')->on('tms_cargoorders');
            $table->unsignedBigInteger('forwardingcontract_id');
            $table->foreign('forwardingcontract_id')->references('id')->on('tms_forwardingcontracts');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tms_forwarding_processes');
    }
};
