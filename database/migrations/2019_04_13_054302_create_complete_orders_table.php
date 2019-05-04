<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompleteOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('complete_orders', function (Blueprint $table) {
            $table->increments('com_order_id');
            
            $table->unsignedInteger('order_id')->nullable();
            $table->foreign('order_id')->references('order_id')->on('tyre_orders');
            
            $table->string('com_order_no')->unique();
            
            $table->unsignedInteger('cus_id')->nullable();
            $table->foreign('cus_id')->references('cus_id')->on('customers');
            
            $table->decimal('com_order_amount',10,2)->nullable();
            $table->decimal('discount',10,2)->nullable();
            $table->decimal('discount_per',10,2)->nullable();
            
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
        Schema::dropIfExists('complete_orders');
    }
}
