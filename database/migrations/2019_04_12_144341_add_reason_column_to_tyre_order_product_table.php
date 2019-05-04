<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddReasonColumnToTyreOrderProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tyre_order_product', function (Blueprint $table) {
            $table->string('serial_no')->nullable()->after('line_amount');
            $table->unsignedInteger('rsn_id')->nullable()->after('serial_no');
            $table->foreign('rsn_id')->references('rsn_id')->on('reason');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tyre_order_product', function (Blueprint $table) {
            $table->dropColumn('serial_no');
            $table->dropForeign(['rsn_id']);
            $table->dropColumn('rsn_id');
        });
    }
}
