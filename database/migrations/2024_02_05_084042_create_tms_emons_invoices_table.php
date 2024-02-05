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
        Schema::create('tms_emons_invoices', function (Blueprint $table) {
            $table->id();
            $table->string('emons_invoice_number')->required()->comment('The invoice number from Emons.');
            $table->date('billing_date')->required()->comment('The date when the invoice was billed.');
            $table->string('order_number')->required()->comment('The order number.');
            $table->string('customer_name')->required()->comment('The customer name.');
            $table->string('customer_country_code')->required()->comment('The customer country code. Example: "DE".');
            $table->string('customer_zip_code')->required()->comment('The customer zip code.');
            $table->string('customer_city')->required()->comment('The customer city.');
            $table->string('receiver_name')->required()->comment('The receiver name.');
            $table->string('receiver_country_code')->required()->comment('The receiver country code. Example: "DE".');
            $table->string('receiver_zip_code')->required()->comment('The receiver zip code.');
            $table->string('receiver_city')->required()->comment('The receiver city.');
            $table->float('netto_price')->required()->comment('The netto price of the invoice from Emons. This will be compared with our price.');
            $table->boolean('is_correct')->default(null)->nullable()->comment('This will be set to null by default. Null means that the netto_price is not checked yet. When the netto_price is checked, the value of this column will be true, if all is OK, and false if the price is wrong.');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tms_emons_invoices');
    }
};
