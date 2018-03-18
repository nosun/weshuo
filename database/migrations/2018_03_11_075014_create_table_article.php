<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableArticle extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('article', function(Blueprint $table){
            $table->increments('id');
            $table->string('title');
            $table->tinyInteger('cid')->default(0);
            $table->string('author', 32)->default('');
            $table->text('content');
            $table->tinyInteger('weight')->default(0);  // 权重
            $table->tinyInteger('visible')->default(1); // 是否可见
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
        Schema::drop('article');
    }
}
