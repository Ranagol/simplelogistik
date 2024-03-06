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
        Schema::table('tms_forwarders', function (Blueprint $table) {
            if (!Schema::hasColumn('tms_forwarders', 'slug')) {
                $table->string('slug')
                        ->after('company_name')
                        ->unique()
                        ->comment('Use this slug instead of company name in Eloquent queries.');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tms_forwarders', function (Blueprint $table) {
            if (Schema::hasColumn('tms_forwarders', 'slug')) {
                $table->dropColumn('slug');
            }
        });
    }
};
