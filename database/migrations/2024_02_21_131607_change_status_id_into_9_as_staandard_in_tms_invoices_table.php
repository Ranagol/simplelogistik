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
        Schema::table('tms_invoices', function (Blueprint $table) {
            $table->unsignedBigInteger('invoice_status_id')->default(9)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tms_invoices', function (Blueprint $table) {
            $table->unsignedBigInteger('invoice_status_id')->default(9)->change();
        });
    }
};
