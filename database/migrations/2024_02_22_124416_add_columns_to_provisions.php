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
        Schema::table('tms_provisions', function (Blueprint $table) {

            if(!Schema::hasColumn('tms_provisions', 'sales_channel')) {
                $table->string('sales_channel')
                        ->after('partner_id')
                        ->comment('Marketplace or PRO or Sales Assistant or Connect or 4You')
                        ->nullable();
                        
            }

            if(!Schema::hasColumn('tms_provisions', 'max_provision_limit_eur')) {
                $table->float('max_provision_limit_eur')
                        ->after('value')
                        ->comment('80 eur for Marketplace, 60 eur for PRO. This is the maximum value of a provision, it can not be higher than this.')
                        ->nullable();
                        
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tms_provisions', function (Blueprint $table) {

            if(Schema::hasColumn('tms_provisions', 'sales_channel')) {
                $table->dropColumn('sales_channel');
            }

            if(Schema::hasColumn('tms_provisions', 'max_provision_limit_eur')) {
                $table->dropColumn('max_provision_limit_eur');
            }
        });
    }
};
