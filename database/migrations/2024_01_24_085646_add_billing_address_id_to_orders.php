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
            if(!Schema::hasColumn('tms_orders', 'billing_address_id')){
                $table->unsignedBigInteger('billing_address_id')->nullable();
                $table->foreign('billing_address_id')->references('id')->on('tms_addresses');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tms_orders', function (Blueprint $table) {
            if (Schema::hasColumn('tms_orders', 'billing_address_id')) {
                // $table->dropForeign('tms_orders_billing_address_id_foreign');
                $table->dropColumn('billing_address_id');
            }
        });
    }
};
