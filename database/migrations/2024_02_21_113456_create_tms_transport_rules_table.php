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
        Schema::create('tms_transport_rules', function (Blueprint $table) {
            $table->id();
            $table->string('action_type')->comment('Example: setPartner. Or: setOrderTransportType.');
            //In Pamyra json file
            $table->string('source_field')->comment('Example: calculationModelName. The field that contains the key word in Pamyra json file.')->nullable();
            $table->string('condition_operator')->comment('Example: equal. Or: %LIKE%. If the type of transport is equal to Stuckgut then...')->nullable();
            $table->string('keyphrase')->comment('Example: Stückgut. We search for this keyword or keyphrase.')->nullable();
            //In db
            $table->string('target_table_name')->comment('The name of the target table in our db.')->nullable();
            $table->string('target_column_name')->comment('The field that should be updated in out db table.')->nullable();
            $table->string('target_new_value')->comment('The value that should be set in our db table.')->nullable();

            $table->text('description')->comment('The description of the rule in non-programmer terms.')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tms_transport_rules');
    }
};
