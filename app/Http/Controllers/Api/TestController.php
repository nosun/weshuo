<?php

namespace App\Http\Controllers\Api;

use App\ModelHelpers\UserHelper;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redis;
use App\ModelHelpers\NovelHelper;

class TestController extends Controller
{
    public function index(){
        Redis::set('test',1);
        return Redis::get('test');
    }

    public function getNovels(){
        $uid = 1;
        $history = UserHelper::getUserReadingHistory($uid);
        dd($history);
    }
}
