<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPaidStatusColumnToCompleteOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('complete_orders', function (Blueprint $table) {
            $table->tinyInteger('paid_status')->default('0')->comments('0-not paid, 1-paid')->after('added_by');
            $table->timestamp('paid_at')->nullable()->after('paid_status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('complete_orders', function (Blueprint $table) {
            $table->dropColumn(['paid_status','paid_at']);
        });
    }
}
