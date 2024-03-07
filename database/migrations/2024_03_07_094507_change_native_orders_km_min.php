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
        Schema::table('tms_native_orders', function (Blueprint $table) {
            if (Schema::hasColumn('tms_native_orders', 'distance_km')) {
                $table->integer('distance_km')->change();
            }
            if (Schema::hasColumn('tms_native_orders', 'duration_minutes')) {
                $table->integer('duration_minutes')->change();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tms_native_orders', function (Blueprint $table) {
            if (Schema::hasColumn('tms_native_orders', 'distance_km')) {
                $table->float('distance_km')->change();
            }
            if (Schema::hasColumn('tms_native_orders', 'duration_minutes')) {
                $table->float('duration_minutes')->change();
            }
        });
    }
};
