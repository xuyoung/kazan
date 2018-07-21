<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * 用户表
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user', function (Blueprint $table) {
            $table->increments('user_id')->comment('用户ID');;
            $table->string('user_account', 32)->comment('用户名');
            $table->string('user_name', 32)->comment('姓名');
            $table->string('password', 50)->comment('密码');
            $table->integer('role_id')->comment('角色ID');
            $table->integer('user_status')->comment('用户状态');
            $table->string('phone_number', 32)->comment('手机号码');
            $table->smallInteger('list_number')->unsigned()->comment('用户序号');
            $table->string('user_name_py', 50)->comment('用户名的拼音');
            $table->string('user_name_zm', 50)->comment('用户名的字母');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user');
    }
}
