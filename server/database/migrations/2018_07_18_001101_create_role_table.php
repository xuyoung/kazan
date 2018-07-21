<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRoleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * 角色表
     *
     * @return void
     */
    public function up()
    {
        Schema::create('role', function (Blueprint $table) {
            $table->increments('role_id')->comment('角色ID');
            $table->string('role_name', 32)->comment('角色名称');
            $table->smallInteger('role_no')->comment('角色序号');
            $table->string('role_name_py', 50)->comment('角色名称拼音');
            $table->string('role_name_zm', 50)->comment('角色名称首字母');
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
        Schema::dropIfExists('role');
    }
}
