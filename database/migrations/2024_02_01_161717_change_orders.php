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
            $table->string('order_number')->nullable()->after('order_status_id')->comment('This is our internal order number');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tms_orders', function (Blueprint $table) {
            $table->dropColumn('order_number');
        });
    }
};
