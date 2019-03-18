<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBeltPricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('belt_prices', function (Blueprint $table) {
            $table->increments('price_id');
            $table->unsignedInteger('tyre_id')->nullable();
            $table->foreign('tyre_id')->references('tyre_id')->on('tyres');

            $table->unsignedInteger('cat_id')->nullable();
            $table->foreign('cat_id')->references('cat_id')->on('belt_categories');

            $table->unsignedInteger('sub_cat_id')->nullable();
            $table->foreign('sub_cat_id')->references('sub_cat_id')->on('belt_subcategories');

            $table->string('price_no');
            $table->double('rp_price', 8, 2);
            $table->double('cus_price', 8, 2);
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
        Schema::dropIfExists('belt_prices');
    }
}
