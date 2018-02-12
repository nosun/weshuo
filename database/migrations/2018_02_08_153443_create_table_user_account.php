<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableUserAccount extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_account', function (Blueprint $table) {
            /*
             * 用户账户表
             */
            $table->increments('id');
            $table->string('user_id')->unique(); //订阅者微信open_id
            $table->string('point'); // 当前点
            $table->float('change'); // 变更
            $table->integer('novel_id'); // 小说id，辅助字段
            $table->string('detail'); // 详细说明
            $table->enum('type',
                ['recharge','present','consume','refund']); // 类型
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
        Schema::drop('user_account');
    }
}
