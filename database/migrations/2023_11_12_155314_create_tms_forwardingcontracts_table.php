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
        Schema::create('tms_forwardingcontracts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('internalfcid', 200);                           // e.g.  fc00-0007-1093-0276-92bc4f1a-8180-11ee-b962-0242ac120002
            $table->unsignedBigInteger('forwarder_id');
            $table->foreign('forwarder_id')->references('id')->on('tms_forwarders');
            $table->unsignedBigInteger('customer_id');
            $table->foreign('customer_id')->references('id')->on('tms_customers');
            $table->unsignedBigInteger('vehicle_id')->nullable();
            $table->foreign('vehicle_id')->references('id')->on('tms_vehicles');
            $table->unsignedBigInteger('dispatcher_id');
            $table->foreign('dispatcher_id')->references('id')->on('tms_dispatchers');
            $table->string('comments', 255)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tms_forwardingcontracts');
    }
};
