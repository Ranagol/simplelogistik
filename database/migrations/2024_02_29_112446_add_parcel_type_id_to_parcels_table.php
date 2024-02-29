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
            if (!Schema::hasColumn('tms_parcels', 'parcel_type_id')) {
                $table->foreignId('parcel_type_id')->constrained('tms_parcel_types');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tms_parcels', function (Blueprint $table) {
            if (Schema::hasColumn('tms_parcels', 'parcel_type_id')) {
                $table->dropForeign(['parcel_type_id']);
                $table->dropColumn('parcel_type_id');
            }
        });
    }
};
