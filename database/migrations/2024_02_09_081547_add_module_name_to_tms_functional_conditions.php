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
        Schema::table('tms_functional_conditions', function (Blueprint $table) {
            $table->string('module_name', 100)->comment('This is the name of the module.')->after('field_name')->nullable();
            $table->string('module_status', 100)->comment('This is the status of the module.')->after('module_name')->default('enabled');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tms_functional_condition', function (Blueprint $table) {
            $table->dropColumn('module_name');
            $table->dropColumn('module_status');
        });
    }
};
