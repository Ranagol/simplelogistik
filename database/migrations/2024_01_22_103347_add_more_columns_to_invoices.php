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
            $table->float('invoice_sum_without_tax', 8, 2)->nullable()->after('payment_date');//Object of type Illuminate\Database\Schema\Blueprint is not callable
            $table->float('invoice_sum_with_tax', 8, 2)->nullable()->after('invoice_sum_without_tax');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tms_invoices', function (Blueprint $table) {
            $table->dropColumn('invoice_sum_without_tax');
            $table->dropColumn('invoice_sum_with_tax');
            $table->dropColumn('invoice_sum');
        });
    }
};
