<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserPermissionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_permission', function (Blueprint $table) {
            $table->increments('up_id');

            $table->unsignedInteger('pg_id')->nullable();
            $table->foreign('pg_id')->references('pg_id')->on('permission_group');

            $table->unsignedInteger('per_id')->nullable();
            $table->foreign('per_id')->references('per_id')->on('permission');

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
        Schema::dropIfExists('user_permission');
    }
}
