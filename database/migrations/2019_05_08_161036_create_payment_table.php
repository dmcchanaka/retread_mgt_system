<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment', function (Blueprint $table) {
            $table->increments('pay_id');
            $table->string('pay_no')->unique();
            $table->decimal('pay_amount',10,2)->nullable();

            $table->unsignedInteger('cus_id')->nullable();
            $table->foreign('cus_id')->references('cus_id')->on('customers');

            $table->tinyInteger('pay_type')->default('0')->comment('0-cash, 1-cheque');

            $table->unsignedInteger('added_by')->nullable();
            $table->foreign('added_by')->references('id')->on('users');

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
        Schema::dropIfExists('payment');
    }
}
