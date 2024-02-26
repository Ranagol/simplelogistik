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
            if (!Schema::hasColumn('tms_orders', 'owner')) {
                $table->string('owner')->nullable()->after('order_number')->comment('The owner of the order.');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tms_orders', function (Blueprint $table) {
            if (Schema::hasColumn('tms_orders', 'owner')) {
                $table->dropColumn('owner');
            }
        });
    }
};
