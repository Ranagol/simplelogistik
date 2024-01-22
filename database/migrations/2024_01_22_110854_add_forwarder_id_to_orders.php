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
            $table->unsignedBigInteger('forwarder_id')->nullable()->after('partner_id');
            $table->foreign('forwarder_id')->references('id')->on('tms_forwarders')->after('forwarder_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tms_orders', function (Blueprint $table) {
            $table->dropForeign(['forwarder_id']);
        });
    }
};
