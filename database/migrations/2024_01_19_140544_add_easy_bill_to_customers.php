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
            $table->integer('easy_bill_customer_id')->comment('The ID of the customer in EasyBill')->unsigned()->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tms_customers', function (Blueprint $table) {
            $table->dropColumn('easy_bill_customer_id');
        });
    }
};
