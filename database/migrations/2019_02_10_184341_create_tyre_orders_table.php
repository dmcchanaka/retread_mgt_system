<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTyreOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tyre_orders', function (Blueprint $table) {
            $table->increments('order_id');
            $table->string('order_no')->unique();

            $table->unsignedInteger('cus_id')->nullable();
            $table->foreign('cus_id')->references('cus_id')->on('customers');

            $table->double('order_amount',8,2)->nullable();
            $table->double('discount',8,2)->nullable();
            $table->double('discount_per',8,2)->nullable();
            $table->tinyInteger('complete_status')->default('0')->comment('0 - Not complete, 1 - Complete');

            $table->integer('added_by')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tyre_orders');
    }
}
