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
        Schema::create('tms_contacts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('salutation', 100)->nullable();
            $table->string('title', 100)->nullable();
            $table->string('firstname', 100);
            $table->string('secondname', 100);
            $table->string('phonenumber', 100);
            $table->string('email',100);
            $table->unsignedBigInteger('customer_id')->nullable();
            $table->unsignedBigInteger('forwarder_id')->nullable();
            $table->string('comments', 255)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tms_contacts');
    }
};
