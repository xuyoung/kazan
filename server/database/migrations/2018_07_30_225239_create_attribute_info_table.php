<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAttributeInfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * 属性值表
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attribute_info', function (Blueprint $table) {
            $table->increments('attribute_info_id')->comment('属性值ID');
            $table->integer('attribute_id')->comment('属性类别ID');
            $table->string('attribute_info_name', 100)->comment('属性值名称');
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
        Schema::dropIfExists('attribute_info');
    }
}
