<?php

use Illuminate\Http\Request;

Route::namespace('Api')->group(function(){

    /* 其他 */
    Route::get('banners',"PageController@getIndexBanners");

    /* 小说 */
    // 小说列表 {condition}，{order}，{pageSize} {page}
    Route::post('novels',"NovelController@getNovels");
    // 小说目录
    Route::get('catalog/{novel_id}',"NovelController@getCatalog");
    // 获取小说类型
    Route::get('categories',"NovelController@getCategories");
    // 获取文章
    Route::get('article/{id}',"ArticleController@getArticle");


    /* 用户 */
    // 用户登录
    Route::post('user/login', "UserController@login");

    Route::middleware('miniProcessAuth')->group(function(){
        // 个人信息
        Route::get('user', "UserController@getUser");
        // 用户上次阅读
        Route::get('user/last_read',"UserController@getUserLastRead");
        // 我的收藏
        Route::get('user/favorites', "UserController@getUserFavorites");
        // 添加收藏
        Route::post('user/favorite', "UserController@addUserFavorite");
        // 取消收藏
        Route::delete('user/favorite/{novel_id}', "UserController@deleteUserFavorite");
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

        // 小说信息
        Route::get('novel/{novel_id}',"NovelController@getNovel");
        // 小说章节
        Route::get('chapter/{novel_id}/{chapter_id}',"NovelController@getChapter");
    });


    Route::get('test', 'TestController@index');

});