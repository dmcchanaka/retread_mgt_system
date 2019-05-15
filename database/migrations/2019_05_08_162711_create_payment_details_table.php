<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_details', function (Blueprint $table) {
            $table->increments('pd_id');
            
            $table->unsignedInteger('pay_id')->nullable();
            $table->foreign('pay_id')->references('pay_id')->on('payment');

            $table->unsignedInteger('com_order_id')->nullable();
            $table->foreign('com_order_id')->references('com_order_id')->on('complete_orders');

            $table->decimal('paid_amount',10,2)->nullable();

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
        Schema::dropIfExists('payment_details');
    }
}
