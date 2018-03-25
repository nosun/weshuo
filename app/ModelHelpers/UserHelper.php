<?php

namespace App\ModelHelpers;

use App\Models\Chapter;
use App\Models\Novel;
use App\Models\User;
use App\Models\UserFavorite;
use App\Models\UserReadingHistory;
use Carbon\Carbon;
use DB;

class UserHelper
{
    public static function getUserLastRead($uid)
    {
        $row = DB::table('user_reading_history')
            ->select(['chapter_id','novel_id'])
            ->where('user_id', $uid)
            ->orderBy('id', 'desc')
            ->first();

        $data = [];
        if($row){
            $chapter = Chapter::where('novel_id', $row->novel_id)->where('chapter_id', $row->chapter_id)->first();
            $data = [
                'chapter_id' => $chapter->chapter_id,
                'novel_id' => $chapter->novel_id,
                'title' => $chapter->title,
                'name' => $chapter->novel->name,
            ];
        }
        return $data;
    }

    public static function getUserReadingHistory($uid){
        $results = DB::table('user_reading_history')
            ->select(['chapter_id','novel_id'])
            ->whereIn('id', (function() use ($uid){
                return DB::table('user_reading_history as a')
                    ->select(DB::raw("max(a.id) as id"))
                    ->where('user_id', $uid)
                    ->groupBy('novel_id')
                    ->pluck('id')
                    ->toArray();
            })())->get();

        $data = [];
        if($results){
            foreach($results as $row){
                $chapter = Chapter::where('chapter_id',$row->chapter_id)
                    ->where('novel_id', $row->novel_id)
                    ->first();
                $data[] = [
                    'chapter_id' => $chapter->chapter_id,
                    'novel_id' => $chapter->novel_id,
                    'title' => $chapter->title,
                    'name' => $chapter->novel->name,
                ];
            }
        }

        return $data;
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

    public static function removeFavorite($user_id, $novel_id)
    {
        $result = UserFavorite::where('user_id', $user_id)->where('novel_id', $novel_id)->first();
        if (empty($result)) {
            return true;
        }
        return UserFavorite::where('user_id', $user_id)->where('novel_id', $novel_id)->delete();
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

    public static function addToUserReadingHistory($uid, $novel_id, $chapter_id)
    {
        $model = new UserReadingHistory();
        return $model->fill([
                'user_id' => $uid,
                'novel_id' => $novel_id,
                'chapter_id' => $chapter_id,
                'created_at' => Carbon::now()
            ]
        )->save();
    }
}