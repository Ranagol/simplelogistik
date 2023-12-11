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
        Schema::create('tms_parcels', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tms_cargo_order_id');
            $table->foreign('tms_cargo_order_id')->references('id')->on('tms_cargo_orders');
            $table->integer('width')->comment('Parcel width in cm');
            $table->integer('height')->comment('Parcel height in cm');
            $table->integer('length')->comment('Parcel length in cm');
            $table->decimal('weight', 10, 2)->comment('Parcel weight in kg');
            $table->boolean('is_hazardous')->default(false)->comment('Is the parcel hazardous?');
            $table->boolean('is_stackable')->default(false)->comment('Is the parcel stackable?');
            $table->string('information', 255)->nullable()->comment('Additional information about the parcel');
            $table->integer('name')->comment('This is actually the type of parcel. Example: package, bulky goods, euro pallet, disposable pallet, etc.');//this will be solved with mutators and accessors
            $table->integer('number')->comment('This is a property of Pamyra orders. Not sure what it is for.');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tms_parcels');
    }
};
