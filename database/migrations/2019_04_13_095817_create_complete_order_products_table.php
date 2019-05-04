<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompleteOrderProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('complete_order_products', function (Blueprint $table) {
            $table->increments('cop_id');
            
            $table->unsignedInteger('com_order_id')->nullable();
            $table->foreign('com_order_id')->references('com_order_id')->on('complete_orders');
            
            $table->unsignedInteger('tyre_id')->nullable();
            $table->foreign('tyre_id')->references('tyre_id')->on('tyres');

            $table->unsignedInteger('price_id')->nullable();
            $table->foreign('price_id')->references('price_id')->on('belt_prices');

            $table->double('discount',10,2)->nullable();
            $table->double('discount_per',8,2)->nullable();
            $table->integer('qty')->nullable();
            $table->double('line_amount',10,2)->nullable();
            $table->string('serial_no')->nullable();
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
        Schema::dropIfExists('complete_order_products');
    }
}
