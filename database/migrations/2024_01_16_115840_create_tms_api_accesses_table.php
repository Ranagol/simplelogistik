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
        Schema::create('tms_api_accesses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('api_name')->nullable();
            $table->string('api_key')->nullable();
            $table->string('api_secret')->nullable();
            $table->string('api_url')->nullable();
            $table->string('api_token')->nullable();
            $table->string('api_token_type')->nullable();
            $table->string('api_token_expires_in')->nullable();
            $table->string('api_token_expires_at')->nullable();
            $table->string('api_token_refresh_token')->nullable();
            $table->string('api_token_refresh_token_expires_in')->nullable();
            $table->string('api_token_refresh_token_expires_at')->nullable();
            $table->string('api_token_scope')->nullable();
            

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tms_api_accesses');
    }
};
