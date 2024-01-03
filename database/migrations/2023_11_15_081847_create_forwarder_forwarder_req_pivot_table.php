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
        // PIVOT TABLE BETWEEN tms_forwarder AND tms_forwarder_req
        Schema::create('forwarder_forwarder_req_pivot', function (Blueprint $table) {
            $table->foreignId('tms_forwarder_id')->constrained('tms_forwarders');
            $table->foreignId('tms_forwarder_req_id')->constrained('tms_forwarder_reqs');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('forwarder_forwarder_req_pivot');
    }
};
