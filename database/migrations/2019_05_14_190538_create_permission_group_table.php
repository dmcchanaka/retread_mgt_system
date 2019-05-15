<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePermissionGroupTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('permission_group', function (Blueprint $table) {
            $table->increments('pg_id');
            $table->string('group_name')->nullable();
            $table->unsignedInteger('u_tp_id')->nullable();
            $table->foreign('u_tp_id')->references('u_tp_id')->on('user_types');

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
        Schema::dropIfExists('permission_group');
    }
}
