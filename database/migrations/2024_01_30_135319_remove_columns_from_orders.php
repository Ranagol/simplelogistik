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
            $table->dropColumn('avis_customer_phone');
            $table->dropColumn('avis_sender_phone');
            $table->dropColumn('avis_receiver_phone');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tms_orders', function (Blueprint $table) {
            $table->string('avis_customer_phone')->nullable();
            $table->string('avis_sender_phone')->nullable();
            $table->string('avis_receiver_phone')->nullable();
        });
    }
};
