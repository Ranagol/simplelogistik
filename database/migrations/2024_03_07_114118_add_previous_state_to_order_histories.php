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
        Schema::table('tms_order_histories', function (Blueprint $table) {
            if (!Schema::hasColumn('tms_order_histories', 'previous_state')) {
                $table->json('previous_state')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tms_order_histories', function (Blueprint $table) {
            if (Schema::hasColumn('tms_order_histories', 'previous_state')) {
                $table->dropColumn('previous_state');
            }
        });
    }
};
