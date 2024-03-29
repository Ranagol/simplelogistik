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
            $table->dropColumn('pickup_date_from');
            $table->dropColumn('pickup_date_to');
            $table->dropColumn('pickup_comments');
            $table->dropColumn('delivery_date_from');
            $table->dropColumn('delivery_date_to');
            $table->dropColumn('delivery_comments');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tms_native_orders', function (Blueprint $table) {
            $table->date('pickup_date_from')->nullable();
            $table->date('pickup_date_to')->nullable();
            $table->text('pickup_comments')->nullable();
            $table->date('delivery_date_from')->nullable();
            $table->date('delivery_date_to')->nullable();
            $table->text('delivery_comments')->nullable();
        });
    }
};
