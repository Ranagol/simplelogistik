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
            $table->dropColumn('status');
            $table->unsignedBigInteger('order_status_id')->comment('The id of the order status')->after('forwarder_id');
            $table->foreign('order_status_id')->references('id')->on('tms_order_statuses');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tms_orders', function (Blueprint $table) {
            $table->dropForeign(['order_status_id']);
            $table->string('status')->comment('The status of the order');
        });
    }
};
