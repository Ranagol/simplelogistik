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
        Schema::table('tms_order_histories', function (Blueprint $table) {
            if(Schema::hasColumn('tms_order_histories', 'dispatcher_id')) {
                $table->dropColumn('dispatcher_id');
            }
            if(Schema::hasColumn('tms_order_histories', 'name')) {
                $table->dropColumn('name');
            }

            if(Schema::hasColumn('tms_order_histories', 'comment')) {
                $table->renameColumn('comment', 'details');
            }
            
            if(Schema::hasColumn('tms_order_histories', 'order_status')) {
                $table->dropColumn('order_status');
            }

            if(!Schema::hasColumn('tms_order_histories', 'order_status_id')) {
                $table->unsignedBigInteger('order_status_id')->after('id')->comment('The status of the order, from tms_order_statuses table.');
                $table->foreign('order_status_id')->references('id')->on('tms_order_statuses');
            }

            if(!Schema::hasColumn('tms_order_histories', 'cronjob_name')) {
                $table->string('cronjob_name')
                        ->nullable()
                        ->after('user_id')
                        ->comment('The name of the cronjob that created this order history entry. An entry either can be created by a user or by a cronjob. If it is created by a cronjob, this field will be filled with the name of the cronjob. If it is created by a user, this field will be empty, but the user_id will be filled.');
            }

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tms_order_histories', function (Blueprint $table) {

            if(!Schema::hasColumn('tms_order_histories', 'dispatcher_id')) {
                $table->unsignedInteger('dispatcher_id');
            }

            if(!Schema::hasColumn('tms_order_histories', 'name')) {
                $table->string('name');
            }

            if(Schema::hasColumn('tms_order_histories', 'details')) {
                $table->renameColumn('details', 'comment');
            }

            if(!Schema::hasColumn('tms_order_histories', 'order_status')) {
                $table->string('order_status');
            }

            if(Schema::hasColumn('tms_order_histories', 'order_status_id')) {
                $table->dropForeign('tms_order_histories_order_status_id_foreign');
            }

            if (Schema::hasColumn('tms_order_histories', 'cronjob_name')) {
                $table->dropColumn('cronjob_name');
            }
        });
    }
};
