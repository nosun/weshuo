<?php

namespace App\ModelHelpers;

use App\Models\Chapter;
use App\Models\Novel;
use App\Models\User;
use App\Models\UserFavorite;

class UserHelper
{
    public static function getUserLastRead($uid)
    {
        $chapter = Chapter::find(1);
        return $chapter;
    }

    public static function getUser($openid)
    {
        return User::where('openid', $openid)->first();
    }

    public static function checkFavorite($user_id, $novel_id)
    {
        $result = UserFavorite::where('user_id', $user_id)->where('novel_id', $novel_id)->first();

        if (!$result) {
            return false;
        }

        return true;
    }

    public static function addToFavorite($user_id, $novel_id)
    {
        $result = UserFavorite::where('user_id', $user_id)->where('novel_id', $novel_id)->first();
        if ($result) {
            return true;
        }
        $model = new UserFavorite();
        return $model->fill(['user_id' => $user_id, 'novel_id' => $novel_id])->save();
    }

    public static function getUserFavoriteNovels($uid)
    {
        $novel_ids = UserFavorite::where('user_id', $uid)->get()->pluck('novel_id')->toArray();

        if ($novel_ids) {
            $condition = ['id in' => $novel_ids];
            $novels = NovelHelper::getNovels($condition);
            if ($novels) {
                return $novels;
            }
        }
        return false;
    }
}