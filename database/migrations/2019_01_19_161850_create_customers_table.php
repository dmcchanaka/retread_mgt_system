<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->increments('cus_id');
            $table->string('customer_name');
            $table->tinyInteger('gender')->default('0')->comment('1-Male, 2-Female');
            $table->string('address');
            $table->string('nic');
            $table->string('mobile_no');
            $table->string('email')->unique();
            $table->tinyInteger('customer_type')->default('1')->comment('1-Individual, 2-Company');
            $table->tinyInteger('credit_limit_availability')->default('0')->comment('0-No, 1-Yes');
            $table->double('credit_amount', 8, 2)->nullable();
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
        Schema::dropIfExists('customers');
    }
}
