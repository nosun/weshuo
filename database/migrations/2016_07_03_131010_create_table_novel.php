<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableNovel extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /*
         * 小说表
         * id，标题，简介，作者，封面
         * 属性：类型:[' ']
         * 完本：完本，连载
         * 推荐级别：1-9
         * 热度：计算得出
         * Tag：
         */

        Schema::create('novel', function(Blueprint $table) {
            $table->increments('id');
            $table->string('name'); // 名字
            $table->text('description')->nullable(); // 简介
            $table->string('author_id'); // 作者
            $table->string('cover'); // 封面
            $table->enum('category',[
                'xuanhuan', 'xiuzhen', 'dushi', 'lishi', 'wangyou', 'kehuan', 'other'
            ])->default('other'); // 类型
            $table->bigInteger('hot')->default(0); // 热度
            $table->integer('elite')->default(0);  // 推荐级别
            $table->enum('status',['onroad','finished'])->default('finished');  // 连载 or 完本
            $table->boolean('is_free')->default(False);  // 是否免费
            $table->string('free_chapters')->default('');  // 是否免费
            $table->integer('price')->default(0);    // 价格
            $table->integer('source_url')->default('');    // 价格
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
        Schema::drop('novel');
    }
}
