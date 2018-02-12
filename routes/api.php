<?php

use Illuminate\Http\Request;

Route::namespace('Api')->group(function(){
    /*
     * 小说
     * */
    // 小说列表 {condition}，{order}，{pageSize} {page}
    Route::post('novels',"NovelController@getNovels");
    // 小说目录
    Route::get('catalog/{novel_id}',"NovelController@getCatalog");
    // 小说信息
    Route::get('novel/{novel_id}',"NovelController@getNovel");
    // 小说章节
    Route::get('chapter/{novel_id}/{chapter_id}',"NovelController@getChapter");

    /*
     * 用户
     * */

    // 个人信息
    Route::get('user', "UserController@getUser");
    // 我的收藏
    Route::get('user/favourites', "UserController@getUserFavourite");
    // 添加收藏
    Route::post('user/favourite/{novel_id}', "UserController@addUserFavourite");
    // 取消收藏
    Route::delete('user/favourite/{novel_id}', "UserController@deleteUserFavourite");
    // 购买小说
    Route::post('user/novel/{novel_id}', "UserController@addUserNovel");
    // 我的小说
    Route::get('user/novels', "UserController@getUserNovel");
    // 阅读历史
    Route::get('user/reading_history', "UserController@getUserReadingHistory");
    // 清空历史
    Route::delete('user/reading_history', "UserController@deleteUserReadingHistory");
    // 充值
    Route::post('recharge', "UserController@recharge");
    // 充值历史
    Route::get('user/recharge_history', "UserController@getUserRechargeHistory");
    // 我的账户
    Route::get('user/accounts', "UserController@getUserAccounts");

});