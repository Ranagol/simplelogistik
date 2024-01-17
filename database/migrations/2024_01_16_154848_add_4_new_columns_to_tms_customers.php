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
        Schema::table('tms_customers', function (Blueprint $table) {
            //Newly added columns
            $table->string('email_for_invoice')->nullable();
            $table->string('email_for_label')->nullable();
            $table->string('email_for_pod')->comment('email for proof of delivery')->nullable();
            $table->string('customer_reference')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tms_customers', function (Blueprint $table) {
            //
        });
    }
};
