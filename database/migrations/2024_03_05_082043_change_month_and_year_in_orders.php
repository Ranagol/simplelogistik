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
        Schema::table('tms_orders', function (Blueprint $table) {
            if(Schema::hasColumn('tms_orders', 'month_and_year')) {
                $table->dateTime('month_and_year')->change();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tms_orders', function (Blueprint $table) {
            if(Schema::hasColumn('tms_orders', 'month_and_year')) {
                $table->string('month_and_year')->change();
            }
        });
    }
};
