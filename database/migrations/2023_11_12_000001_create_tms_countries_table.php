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
        Schema::create('tms_countries', function (Blueprint $table) {
            //Data source for countries: https://www.iban.com/country-codes
            $table->id();
            $table->string('country_name');
            $table->string('alpha2_code');
            $table->string('alpha3_code');
            $table->unsignedBigInteger('numeric_code')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tms_countries');
    }
};
