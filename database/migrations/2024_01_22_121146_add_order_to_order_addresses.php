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
        Schema::table('tms_order_addresses', function (Blueprint $table) {
            $table->unsignedInteger('order')
                ->nullable()
                ->after('id')
                ->comment('During the order creation, pickup and delivery addresses are created. In certain time order. First created. Second created. This order is important, and every address must know its order.)');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tms_order_addresses', function (Blueprint $table) {
            $table->dropColumn('order');
        });
    }
};
