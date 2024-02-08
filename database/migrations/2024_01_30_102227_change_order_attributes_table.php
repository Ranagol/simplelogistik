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
        Schema::table('tms_order_attributes', function (Blueprint $table) {
            $table->dropColumn('type');
            $table->dropForeign(['tms_order_id']);
            $table->string('name')->comment('Name of the attribute in Simplelogistik')->after('id');
            $table->string('name_from_partner')->comment('Attribute naming from partner')->after('name');
            $table->unsignedBigInteger('partner_id')->comment('An attribute always belongs to a cargo order.')->after('name_from_partner');
            $table->foreign('partner_id')->references('id')->on('tms_partners');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tms_order_attributes', function (Blueprint $table) {
            if (!Schema::hasColumn('tms_order_attributes', 'type')) {
                $table->string('type')->nullable();
            }

            if (!Schema::hasColumn('tms_order_attributes', 'tms_order_id')) {
                $table->unsignedBigInteger('tms_order_id')->comment('An attribute always belongs to a cargo order.');
                $table->foreign('tms_order_id')->references('id')->on('tms_orders');
            }

            if (Schema::hasColumn('tms_order_attributes', 'partner_id')) {
                $table->dropForeign('partner_id');    
            }
        });
    }
};
