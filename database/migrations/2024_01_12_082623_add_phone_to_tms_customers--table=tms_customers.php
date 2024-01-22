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
        Schema::table('tms_customers', function (Blueprint $table) {
            $table->string('phone')->nullable()->after('email');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        /**
         * If you want to ensure that the column exists before trying to drop it, you can use 
         * the hasColumn method to check if the column exists.
         */
        if (Schema::hasColumn('tms_customers', 'phone')) {
            Schema::table('tms_customers', function (Blueprint $table) {
                $table->dropColumn('phone');
            });
        }
    }
};
