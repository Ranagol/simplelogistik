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
        Schema::table('tms_dispatchers', function (Blueprint $table) {
            Schema::dropIfExists('tms_dispatchers');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tms_dispatchers', function (Blueprint $table) {
            Schema::create('tms_dispatchers', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->unsignedBigInteger('user_id');
                $table->foreign('user_id')->references('id')->on('users');
                $table->string('name');
                $table->string('email');
                $table->string('password');
                $table->string('phone');
                $table->timestamps();
            });
        });
    }
};
