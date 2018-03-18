<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Ajax;
use App\ModelHelpers\NovelHelper;
use App\ModelHelpers\SessionHelper;
use App\ModelHelpers\UserHelper;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use EasyWeChat\Factory;
use Illuminate\Support\Facades\Redis;

class UserController extends Controller
{

    /*
     * 用户登录
     *
     * */

    public function login(Request $request)
    {
        $code = $request->input('code');

        if (empty($code)) {
            return Ajax::argumentsError();
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
        $authData = $app->auth->session($code);

        if ($authData['openid']) {
            $user = User::where('openid', $authData['openid'])->first();
            if (is_null($user)) {
                $user = new User();
                $user->openid = $authData['openid'];
            }
            $user->language = $request->input('language', 'zh_CN');
            $user->nickname = $request->input('nickName', '');
            $user->country = $request->input('country', '');
            $user->province = $request->input('province', '');
            $user->avatar = $request->input('avatar', '');
            $user->gender = $request->input('gender', 1);
            $user->save();

            $data = [
                'session' => SessionHelper::setSession($authData)
            ];

            return Ajax::success($data);
        }

        return Ajax::serverError($authData);
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
    public function getUserFavorites(Request $request)
    {
        $openid = $request->openid;
        $user = UserHelper::getUser($openid);
        if (empty($user)) {
            return Ajax::forbidden();
        }

        $novels = UserHelper::getUserFavoriteNovels($user->id);

        if(empty($novels)){
            return Ajax::dataEmpty();
        }

        return Ajax::success($novels);
    }

    /*
     * 添加用户收藏
     *
     */
    public function addUserFavorite(Request $request)
    {
        $novel_id = $request->post('novel_id', 0);

        if (empty($novel_id)) {
            return Ajax::argumentsError();
        }

        $user = UserHelper::getUser($request->openid);

        if (empty($user)) {
            return Ajax::forbidden();
        }

        $result = UserHelper::addToFavorite($user->id, $novel_id);

        if ($result === false) {
            return Ajax::serverError('add favorite fail');
        }

        return Ajax::success();
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
