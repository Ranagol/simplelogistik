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
        Schema::create('tms_offerprices', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('description', 255);
            $table->dateTime('offerfrom')->nullable();
            $table->dateTime('offerto')->nullable();
            $table->unsignedBigInteger('forwarder_id');
            $table->unsignedBigInteger('order_id')->nullable();
            $table->decimal('offeredprice',10,2);
            $table->decimal('offeredpricenet',10,2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tms_offerprices');
    }
};
