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
        Schema::create('tms_user_settings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->string('setting_type')->nullable()->comment('Example: columns/filters/dashboardOrders, themeColors, userLanguage');
            $table->string('location')->nullable()->comment('on which page or feature we set this setting');
            $table->json('settings')->nullable()->comment('json data of settings for the user on the specific location');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tms_user_settings');
    }
};
