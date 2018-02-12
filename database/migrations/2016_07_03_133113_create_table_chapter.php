<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableChapter extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /*
         * 章节表：存放小说的章节内容
         */
        Schema::create('chapter', function(Blueprint $table){
            $table->increments('id');
            $table->integer('novel_id')->index(); // 小说的 id
            $table->string('title');              // 章节的标题
            $table->longText('content')->nullable(); // 章节的内容
            $table->bigInteger('views')->default(0); // 章节的阅读数
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
        //
        Schema::drop('chapter');
    }
}
