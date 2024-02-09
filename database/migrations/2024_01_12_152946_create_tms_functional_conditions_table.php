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
        Schema::create('tms_functional_conditions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('field_name', 100)->comment('This is the name of a column in a table from database.')->unique();            
            $table->string('dependency_status', 255)->default(json_encode(['']));                      // should be like {"paypal" => {"text" => "working", "icon" => "fa-check-circle"}}
            $table->string('field_info', 255)->comment('Detailed informations for the user.')->nullable()->default('');
            $table->string('field_icon', 100)->default('fa fa-question-circle');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tms_functional_conditions');
    }
};
