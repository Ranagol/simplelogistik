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
        Schema::table('tms_partners', function (Blueprint $table) {
            if (!Schema::hasColumn('tms_partners', 'legal_entity_type')) {
                $table->unsignedInteger('legal_entity_type')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tms_partners', function (Blueprint $table) {
            if (Schema::hasColumn('tms_partners', 'legal_entity_type')) {
                $table->dropColumn('legal_entity_type');
            }
        });
    }
};
