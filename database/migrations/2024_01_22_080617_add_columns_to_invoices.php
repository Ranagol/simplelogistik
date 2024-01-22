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
            $table->integer('invoice_type')
                    ->default(1)
                    ->comment('1 = Invoice, 2 = Credit, defined in TmsInvoice.php')
                    ->after('invoice_number');

            $table->string('invoice_link')
                    ->nullable()
                    ->comment('Link to the invoice file')
                    ->after('invoice_type');

            $table->date('payment_date')
                    ->nullable()
                    ->comment('Date when the invoice was paid')
                    ->after('invoice_link');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tms_invoices', function (Blueprint $table) {
            $table->dropColumn('invoice_type');
            $table->dropColumn('invoice_link');
            $table->dropColumn('payment_date');
        });
    }
};
