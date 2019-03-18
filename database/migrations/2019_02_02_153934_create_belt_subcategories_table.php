<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBeltSubcategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('belt_subcategories', function (Blueprint $table) {
            $table->increments('sub_cat_id');
            $table->string('sub_cat_name');

            $table->unsignedInteger('cat_id');
            $table->foreign('cat_id')->references('cat_id')->on('belt_categories');

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
        Schema::dropIfExists('belt_subcategories');
    }
}
