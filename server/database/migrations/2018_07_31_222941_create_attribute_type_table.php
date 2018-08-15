<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAttributeTypeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * 属性类别表
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attribute_type', function (Blueprint $table) {
            $table->increments('attribute_type_id')->comment('属性类别ID');
            $table->string('attribute_type_name', 100)->comment('属性类别名称');
            $table->string('attribute_type_name_py', 50)->comment('属性类别名称的拼音');
            $table->string('attribute_type_name_zm', 50)->comment('属性类别名称的字母');
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
        Schema::dropIfExists('attribute_type');
    }
}
