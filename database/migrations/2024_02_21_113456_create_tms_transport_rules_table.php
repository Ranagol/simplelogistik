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
            $table->string('name')->unique()->comment('Example: pamyra-stuckgut-partner. The first part is company name involved. The second part is the search term/topic/name used in the rule. If needed add additional parts with - as separator.');
            $table->string('created_by')->comment('The user who created the rule.')->nullable();
            $table->text('description')->comment('The description of the rule in non-programmer terms.')->nullable();
            $table->string('condition_field')->comment('Example: type of transport. If the type of transport is ... then...');
            $table->string('condition_content')->comment('Example: the phrase Stuckgut. If the type of transport is Stuckgut then...');
            $table->string('condition_operator')->comment('Example: equal. If the type of transport is equal to Stuckgut then...');
            $table->string('consequence')->comment('Example: ...then the price is 100. A description what will happen, if the condition is met. If the type_of_transport is Stuckgut, then the Partner should be automatically Partner Emons Villingen (when processing the pamyra json file)');
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
