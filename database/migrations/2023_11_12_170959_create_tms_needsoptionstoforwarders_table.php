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
        Schema::create('tms_needsoptionstoforwarders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('needandoption_id');
            $table->foreign('needandoption_id')->references('id')->on('tms_needsandoptions');
            $table->unsignedBigInteger('forwarder_id');
            $table->foreign('forwarder_id')->references('id')->on('tms_forwarders');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tms_needsoptionstocustomersforwarders');
    }
};
