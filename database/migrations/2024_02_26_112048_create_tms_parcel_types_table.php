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
        Schema::create('tms_parcel_types', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable()->comment('This is actually the translatable string.');
            $table->string('description')->nullable()->comment('This will be the actual value of the constant, defined in the models.');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tms_parcel_types');
    }
};
