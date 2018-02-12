<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableUserTransaction extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_transaction', function (Blueprint $table) {
            /*
             * 交易表：充值或者退款
             */
            $table->increments('id');
            $table->string('user_id')->unique();    // user_id
            $table->enum('type', ['pay','refund']); // 类型
            $table->float('amount');  // 金额
            $table->integer('status')->default(0);  // 状态
            $table->string('detail'); // 详情
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
        Schema::drop('user_transaction');
    }
}
