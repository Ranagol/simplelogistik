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
            $table->unsignedBigInteger('invoice_status_id')->comment('The id of the invoice status')->after('forwarder_id');
            $table->foreign('invoice_status_id')->references('id')->on('tms_invoice_statuses');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tms_invoices', function (Blueprint $table) {
            $table->dropForeign(['invoice_status_id']);
        });
    }
};
