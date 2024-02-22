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
        Schema::create('tms_provisions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('partner_id')->nullable();
            $table->foreign('partner_id')->references('id')->on('tms_partners');
            $table->float('value', 10, 2)->comment('The provision value in percentage. Example: 1.5%')->nullable();
            $table->date('valid_from')->comment('The provision is valid from this date');
            $table->date('valid_to')->comment('The provision is valid to this date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tms_provisions');
    }
};
