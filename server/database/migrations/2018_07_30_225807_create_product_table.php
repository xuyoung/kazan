<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * 产品表
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product', function (Blueprint $table) {
            $table->increments('product_id')->comment('产品ID');
            $table->string('product_name', 32)->comment('产品名称');
            $table->integer('attribute_type_id')->comment('属性类别ID');
            $table->integer('attribute_value_id')->comment('属性值ID');
            $table->string('product_name_py', 50)->comment('产品名称的拼音');
            $table->string('product_name_zm', 50)->comment('产品名称的字母');
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
        Schema::dropIfExists('product');
    }
}
