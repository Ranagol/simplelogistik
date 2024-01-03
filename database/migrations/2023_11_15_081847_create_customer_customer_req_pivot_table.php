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
        // PIVOT TABLE BETWEEN TMS_CUSTOMER AND TMS_CUSTOMER_REQ
        Schema::create('customer_customer_req_pivot', function (Blueprint $table) {
            $table->foreignId('tms_customer_id')->constrained('tms_customers');
            $table->foreignId('tms_customer_req_id')->constrained('tms_customer_reqs');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_customer_req_pivot');
    }
};
