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
            if (Schema::hasColumn('tms_native_orders', 'payment_method')) {
                $table->dropColumn('payment_method');
            }
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tms_native_orders', function (Blueprint $table) {
            if (Schema::hasColumn('tms_native_orders', 'payment_method')) {
                $table->string('payment_method')->nullable()->change();
            }
        });
    }
};
