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
            $table->integer('salutation_id')->nullable()->after('forwarder_id')->comment('Salutation ID.');
            $table->integer('title_id')->nullable()->after('salutation_id')->comment('Title ID. Prof.Dr. Prof. Dr. etc.');
            $table->timestamp('exported_at')->nullable()->after('updated_at')->comment('Timestamp when the customer was exported into CSV-File.');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tms_customers', function (Blueprint $table) {
            $table->dropColumn('salutation_id');
            $table->dropColumn('title_id');
            $table->dropColumn('exported_at');
        });
    }
};
