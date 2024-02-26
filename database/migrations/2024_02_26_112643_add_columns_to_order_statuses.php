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
        Schema::table('tms_order_statuses', function (Blueprint $table) {
            if (!Schema::hasColumn('tms_order_statuses', 'name')) {
                $table->string('name')->nullable()->comment('This is actually the translatable string.');
            }
            if (!Schema::hasColumn('tms_order_statuses', 'status_code')) {
                $table->string('status_code')->nullable();
            }
            if (Schema::hasColumn('tms_order_statuses', 'internal_name')) {
                $table->renameColumn('internal_name', 'description');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tms_order_statuses', function (Blueprint $table) {
            if (Schema::hasColumn('tms_order_statuses', 'name')) {
                $table->dropColumn('name');
            }
            if (Schema::hasColumn('tms_order_statuses', 'status_code')) {
                $table->dropColumn('status_code');
            }
            if (Schema::hasColumn('tms_order_statuses', 'description')) {
                $table->renameColumn('description', 'internal_name');
            }
        });
    }
};
