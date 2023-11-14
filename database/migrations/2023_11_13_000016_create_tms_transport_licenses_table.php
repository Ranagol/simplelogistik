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
        Schema::create('tms_transport_licenses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('forwarder_id')->nullable();
            $table->foreign('forwarder_id')->references('id')->on('tms_forwarders');
            $table->string('license_number');
            $table->string('license_name');
            $table->date('license_valid_from');
            $table->date('license_valid_till');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tms_transport_licenses');
    }
};
