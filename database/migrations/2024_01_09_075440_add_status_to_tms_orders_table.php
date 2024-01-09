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

            /**
             * To add a column after a specific column in Laravel, you can use the after method. 
             * This method is used to specify the order of columns in the table
             */
            $table->string('status')->nullable()->after('origin');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tms_orders', function (Blueprint $table) {

            /**
             * If you want to ensure that the column exists before trying to drop it, you can use 
             * the hasColumn method to check if the column exists.
             */
            if (Schema::hasColumn('tms_orders', 'status')) {
                $table->dropColumn('status');
            }
        });
    }
};
