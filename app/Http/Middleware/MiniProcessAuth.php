<?php

namespace App\Http\Middleware;

use App\Helpers\Ajax;
use App\ModelHelpers\SessionHelper;
use App\ModelHelpers\UserHelper;
use Closure;

class MiniProcessAuth
{
    /**
     * Handle an miniProcess Auth Api request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $session = $request->header('session');

        if(!$session){
            return Ajax::argumentsError();
        }

        $session_data = SessionHelper::getSession($session);

        if(!$session_data){
            return Ajax::dataEmpty(); // session 过期了，需要重新登录
        }

        $openid = $session_data['openid'];

        $user = UserHelper::getUser($openid);

        if(empty($user)){
            return Ajax::dataEmpty();
        }

        $request->user = $user;

        return $next($request);
    }
}
