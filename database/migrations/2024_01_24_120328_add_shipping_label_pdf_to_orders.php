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
            $table->string('shipping_label_pdf')->comment('The shipping label pdf.')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tms_orders', function (Blueprint $table) {
            $table->dropColumn('shipping_label_pdf');
        });
    }
};
