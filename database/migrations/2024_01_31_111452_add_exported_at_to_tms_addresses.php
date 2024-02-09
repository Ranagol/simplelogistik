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
        Schema::table('tms_addresses', function (Blueprint $table) {
            $table->timestamp('exported_at')->nullable()->after('updated_at')->comment('Timestamp when the customer was exported into CSV-File.');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tms_addresses', function (Blueprint $table) {
            $table->dropColumn('exported_at');
        });
    }
};
