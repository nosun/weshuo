<?php

namespace App\ModelHelpers;

use Illuminate\Support\Facades\Redis;

class SessionHelper
{
    protected static $sessionPrefix='session_';

    /**
     * Save Session to Redis
     * @param array $authData
     * @return string SessionKey
     */

    public static function setSession($authData){
        $sessionKey = self::getKey($authData);
        $key = self::$sessionPrefix . $sessionKey;
        Redis::set($key, json_encode($authData));
        return $sessionKey;
    }

    /**
     * Get Session data from Redis
     *
     * @param string $sessionKey
     * @return array $authData
     */

    public static function getSession($sessionKey){
        $key = self::$sessionPrefix . $sessionKey;
        $authData = Redis::get($key);

        if($authData){
            return json_decode($authData, true);
        }

        return null;
    }

    /**
     * Generate key for session
     * @param $authData
     * @return string
     */

    protected static function getKey($authData){
        return md5($authData['openid'].$authData['session_key']);
    }
}