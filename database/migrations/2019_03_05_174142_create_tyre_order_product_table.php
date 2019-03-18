<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTyreOrderProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tyre_order_product', function (Blueprint $table) {
            $table->increments('op_id');

            $table->unsignedInteger('order_id')->nullable();
            $table->foreign('order_id')->references('order_id')->on('tyre_orders');

            $table->unsignedInteger('tyre_id')->nullable();
            $table->foreign('tyre_id')->references('tyre_id')->on('tyres');

            $table->unsignedInteger('price_id')->nullable();
            $table->foreign('price_id')->references('price_id')->on('belt_prices');

            $table->double('discount',10,2)->nullable();
            $table->double('discount_per',8,2)->nullable();
            $table->integer('qty')->nullable();
            $table->double('line_amount',10,2)->nullable();

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
        Schema::dropIfExists('tyre_order_product');
    }
}
