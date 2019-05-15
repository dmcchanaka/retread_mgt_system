<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentChequeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_cheque', function (Blueprint $table) {
            $table->increments('pc_id');
            
            $table->unsignedInteger('pay_id')->nullable();
            $table->foreign('pay_id')->references('pay_id')->on('payment');

            $table->string('cheque_no')->nullable();
            $table->string('bank')->nullable();
            $table->string('branch')->nullable();
            $table->timestamp('cheque_date')->nullable();

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
        Schema::dropIfExists('payment_cheque');
    }
}
