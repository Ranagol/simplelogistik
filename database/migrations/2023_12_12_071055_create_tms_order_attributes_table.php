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
        Schema::create('tms_order_attributes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tms_cargo_order_id')->comment('An attribute always belongs to a cargo order.');
            $table->foreign('tms_cargo_order_id')->references('id')->on('tms_cargo_orders');
            $table->string('type', 200)->comment('Example: customer chooses extra service, like sms notification when package is delivered. This has additional cost.')->nullable();
            $table->decimal('price', 10, 2)->comment('The price of the attribute/extra service.')->nullable();
            $table->string('description', 255)->comment('This is a description column')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tms_order_attributes');
    }
};
