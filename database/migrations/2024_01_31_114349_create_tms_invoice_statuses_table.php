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
        Schema::create('tms_invoice_statuses', function (Blueprint $table) {
            $table->id();
            $table->string('internal_name')->comment('The internal name of the invoice status');
            $table->string('external_name')->comment('The external name of the invoice status')->nullable();
            $table->unsignedBigInteger('partner_id')->comment('The id of the partner that is the source of the invoice status')->nullable();
            $table->foreign('partner_id')->references('id')->on('tms_partners');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tms_invoice_statuses');
    }
};
