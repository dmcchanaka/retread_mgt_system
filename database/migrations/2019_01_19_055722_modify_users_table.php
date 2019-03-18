<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users',function(Blueprint $table){
        $table->unsignedInteger('u_tp_id')->after('name');
        $table->foreign('u_tp_id')->references('u_tp_id')->on('user_types');

        $table->string('nic')->after('email');
        $table->string('mobile_no')->after('nic');
        $table->tinyInteger('gender')->default('0')->comment('1-Male, 2-Female')->after('mobile_no');
        $table->string('address')->after('gender');
        $table->softDeletes()->after('remember_token');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users',function(Blueprint $table){
            $table->dropColumn('u_tp_id');
            $table->dropColumn('nic');
            $table->dropColumn('mobile_no');
            $table->dropColumn('gender');
            $table->dropColumn('address');
            $table->dropColumn('deleted_at');
        });

    }
}
