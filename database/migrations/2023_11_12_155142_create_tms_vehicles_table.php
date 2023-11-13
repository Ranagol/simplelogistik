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
        Schema::create('tms_vehicles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 100);
            $table->decimal('maxsumweight', 10,2);
            $table->decimal('maxpicupweight',10,2);
            $table->decimal('maxpicupwidth',10,2);
            $table->decimal('maxpicupheight',10,2);
            $table->decimal('maxpicuplength',10,2);
            $table->string('vehicletype', 100);
            $table->string('platenumber', 50);
            $table->unsignedBigInteger('forwarder_id');
            $table->foreign('forwarder_id')->references('id')->on('tms_forwarders');
            $table->unsignedBigInteger('address_id');
            $table->foreign('address_id')->references('id')->on('tms_addresses');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tms_vehicles');
    }
};
