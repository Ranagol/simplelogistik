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
            $table->foreign('tms_cargo_order_id')->references('id')->on('tms_orders');
            $table->boolean('is_hazardous')->default(false)->comment('Is the parcel hazardous?');
            $table->string('information', 255)->nullable()->comment('Additional information about the parcel');

            //Columns coming from Pamyra. All column from Pamyra must be prefixed with p_.
            $table->string('p_name')->comment('This is actually the type of parcel. Example: package, bulky goods, euro pallet, disposable pallet, etc.');
            $table->float('p_height', 10, 2)->comment('Parcel height in cm');
            $table->float('p_length', 10, 2)->comment('Parcel length in cm');
            $table->float('p_width', 10, 2)->comment('Parcel width in cm');
            $table->string('p_number')->comment('This is a property of Pamyra orders. Number is an index of transport objects.');
            $table->boolean('p_stackable')->comment('Is the parcel stackable?');
            $table->float('p_weight', 10, 2)->comment('Parcel weight in kg');
            
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
