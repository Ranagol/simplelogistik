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
        Schema::create('tms_customers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('internal_cid', 20);                           // e.g.  C000 0007 1093 0276 0123 4567 89AB CDEF
            $table->string('name', 100);
            $table->string('email', 200);
            $table->string('company_name',200)->nullable();
            $table->string('tax_number',200)->nullable();
            $table->integer('rating')->unsigned()->nullable();
            $table->softDeletes($column = 'deleted_at', $precision = 0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tms_customers');
    }
};
