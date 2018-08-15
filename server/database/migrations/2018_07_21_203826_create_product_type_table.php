<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductTypeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * 产品类别表
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_type', function (Blueprint $table) {
            $table->increments('product_type_id')->comment('产品类别ID');
            $table->string('product_type_name', 32)->comment('产品类别名称');
            $table->string('product_type_name_py', 50)->comment('产品类别名称的拼音');
            $table->string('product_type_name_zm', 50)->comment('产品类别名称的字母');
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
        Schema::dropIfExists('product_type');
    }
}
