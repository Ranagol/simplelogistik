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
        Schema::table('tms_pamyra_orders', function (Blueprint $table) {
            $table->dateTime('date_of_sale')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tms_pamyra_orders', function (Blueprint $table) {
            $table->string('date_of_sale')->nullable()->change();
        });
    }
};
