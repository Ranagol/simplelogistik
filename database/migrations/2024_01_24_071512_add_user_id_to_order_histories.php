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
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tms_order_histories', function (Blueprint $table) {
            if (!Schema::hasColumn('tms_order_histories', 'dispatcher_id')) {
                $table->unsignedBigInteger('dispatcher_id')->nullable();
                $table->foreign('dispatcher_id')->references('id')->on('tms_dispatchers');
            }
            $table->dropForeign(['user_id']);
        });
    }
};
