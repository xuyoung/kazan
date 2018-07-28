<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFormulaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('formula', function (Blueprint $table) {
            $table->increments('formula_id');
            $table->integer('product_id')->comment('产品ID');
            $table->string('cloth_size', 100)->comment('布号');
            $table->mediumText('formula_json')->comment('公式');
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
        Schema::dropIfExists('formula');
    }
}
