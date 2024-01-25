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
            $table->renameColumn('p_name', 'name');
            $table->renameColumn('p_height', 'height');
            $table->renameColumn('p_length', 'length');
            $table->renameColumn('p_width', 'width');
            $table->renameColumn('p_number', 'number');
            $table->renameColumn('p_stackable', 'stackable');
            $table->renameColumn('p_weight', 'weight');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tms_parcels', function (Blueprint $table) {
            //
        });
    }
};
