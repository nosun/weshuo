<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Ajax;
use App\ModelHelpers\NovelHelper;
use App\ModelHelpers\UserHelper;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use EasyWeChat\Factory;

class UserController extends Controller
{


    /*
     * 用户登录
     *
     * */

    public function login(Request $request)
    {
        $data = $request->input('data');
        $code = isset($data->code) ? $data->code : null;
        if (empty($code)) {
            Ajax::argumentsError();
        }

        $config = [
            'app_id' => env('WEAPP_APPID'),
            'secret' => env('WEAPP_APPSECRET'),

            // 下面为可选项
            // 指定 API 调用返回结果的类型：array(default)/collection/object/raw/自定义类名
            'response_type' => 'array',

            'log' => [
                'level' => 'debug',
                'file' => __DIR__ . '/wechat.log',
            ],
        ];

        $app = Factory::miniProgram($config);
        $result = $app->auth->session($code);

        Ajax::success($result);
    }

    /*
     * 增加用户
     *
     */
    public function addUser()
    {

    }

    /*
     * 获取用户信息
     *
     */
    public function getUser()
    {

    }

    public function getUserLastRead()
    {
        $uid = 1;
        $chapter = UserHelper::getUserLastRead($uid);

        if (empty($chapter)) {
            return Ajax::dataEmpty();
        }

        $last_read = [
            'chapter' => $chapter,
            'novel' => $chapter->novel
        ];

        return Ajax::success($last_read);
    }

    /*
     * 获取用户收藏
     *
     */
    public function getUserFavourite()
    {

    }

    /*
     * 添加用户收藏
     *
     */
    public function addUserFavourite()
    {

    }

    /*
     * 删除用户收藏
     *
     */
    public function deleteUserFavourite()
    {

    }

    /*
     * 用户购买小说
     *
     * */
    public function addUserNovel()
    {

    }

    /*
     * 获取用户小说
     *
     * */

    public function getUserNovel()
    {

    }

    /*
     * 获取用户阅读历史
     *
     * */
    public function getUserReadingHistory()
    {

    }

    /*
     * 清空用户阅读历史
     *
     * */
    public function deleteUserReadingHistory()
    {

    }

    /*
     * 充值
     * */

    public function recharge()
    {

    }

    /*
     * 获取用户充值历史
     * */

    public function getUserRechargeHistory()
    {

    }

    /*
     * 获取用户账户信息
     * */

    public function getUserAccount()
    {

    }
}
