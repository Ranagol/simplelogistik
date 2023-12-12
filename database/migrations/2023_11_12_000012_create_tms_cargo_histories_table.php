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
        Schema::create('tms_cargo_histories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('comment');
            $table->string('order_status');
            $table->decimal('additional_cost', 10, 2)->comment('These are the unplanned additinal cost of a cargo order.')->nullable();

            $table->unsignedBigInteger('cargo_order_id');
            $table->foreign('cargo_order_id')->references('id')->on('tms_cargo_orders');
            $table->unsignedBigInteger('forwarder_id');
            $table->foreign('forwarder_id')->references('id')->on('tms_forwarders');
            $table->unsignedBigInteger('customer_id');
            $table->foreign('customer_id')->references('id')->on('tms_customers');
            $table->unsignedBigInteger('forwarding_contract_id');
            $table->foreign('forwarding_contract_id')->references('id')->on('tms_forwarding_contracts');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tms_cargo_histories');
    }
};
