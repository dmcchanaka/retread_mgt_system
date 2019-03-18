<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReceivedBeltsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('received_belts', function (Blueprint $table) {
            $table->increments('rec_id');
            $table->unsignedInteger('grn_id')->nullable();
            $table->foreign('grn_id')->references('grn_id')->on('good_recieveds');
            $table->unsignedInteger('tyre_id')->nullable();
            $table->foreign('tyre_id')->references('tyre_id')->on('tyres');
            $table->unsignedInteger('price_id')->nullable();
            $table->foreign('price_id')->references('price_id')->on('belt_prices');
            $table->integer('qty');
            $table->integer('remaining_qty');
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
        Schema::dropIfExists('received_belts');
    }
}
