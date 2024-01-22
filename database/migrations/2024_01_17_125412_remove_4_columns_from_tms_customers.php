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
        Schema::table('tms_customers', function (Blueprint $table) {
            //Deleting 4 columns from the table
            $table->dropColumn(['paypal', 'sofort', 'amazon', 'vorkasse']);

            //Adding 1 new column to the table
            $table->json('payment_method_options_to_offer')
                ->comment('This is a json column. It will store an array of payment methods that the customer can use. Example: ["paypal", "sofort", "amazon", "vorkasse"]. Only these selected payment options (not all existing possible payment options) will be offere for customer to choose the final payment option.')
                ->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tms_customers', function (Blueprint $table) {
            //Individual customer data - payment methods
            $table->boolean('paypal')->default(false);
            $table->boolean('sofort')->default(false);
            $table->boolean('amazon')->default(false);
            $table->boolean('vorkasse')->default(false);
            $table->dropColumn(['payment_method_options_to_offer']);
        });
    }
};
