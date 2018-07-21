<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExpressFeeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * 快递费模板管理表
     *
     * @return void
     */
    public function up()
    {
        Schema::create('express_fee', function (Blueprint $table) {
            $table->increments('express_fee_id')->comment('快递费模板ID';
            $table->string('area', 32)->comment('区域');
            $table->string('first_weight', 32)->comment('首重');
            $table->decimal('first_fee', 10, 1)->comment('首费');
            $table->string('additional_weight', 32)->comment('续重');
            $table->decimal('additional_fee', 10, 1)->comment('续费');
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
        Schema::dropIfExists('express_fee');
    }
}
