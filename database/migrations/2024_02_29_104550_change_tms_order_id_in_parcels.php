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
        Schema::table('tms_parcels', function (Blueprint $table) {
            if (Schema::hasColumn('tms_parcels', 'tms_order_id')) {
                // Drop the foreign key constraint
                $table->dropForeign(['tms_order_id']);

                // Rename the column
                $table->renameColumn('tms_order_id', 'order_id');

                // Add the foreign key constraint back to the new column
                $table->foreign('order_id')->references('id')->on('tms_orders');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tms_parcels', function (Blueprint $table) {
            if (Schema::hasColumn('tms_parcels', 'order_id')) {
                // Drop the foreign key constraint
                $table->dropForeign(['order_id']);

                // Rename the column
                $table->renameColumn('order_id', 'tms_order_id');

                // Add the foreign key constraint back to the new column
                $table->foreign('tms_order_id')->references('id')->on('tms_orders');
            }
        });
    }
};
