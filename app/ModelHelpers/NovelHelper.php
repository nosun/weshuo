<?php

namespace App\ModelHelpers;

use App\Models\Chapter;
use App\Models\Novel;
use App\Models\UserFavorite;

class NovelHelper
{
    public static $filterable = ['name', 'author', 'sn', 'category', 'status', 'hot', 'elite', 'is_free'];

    public static function getChapter($novel_id, $chapter_id)
    {
        $chapter = Chapter::where('novel_id', $novel_id)
            ->where('chapter_id', $chapter_id)
            ->first();
        return $chapter;
    }

    public static function getNovel($user_id, $novel_id)
    {
        $novel = Novel::find($novel_id);
        if ($novel) {
            $novel->cover = env('APP_URL') . $novel->cover;
            $novel->favorite = UserHelper::checkFavorite($user_id, $novel_id);
            $novel->last_chapter = Chapter::where('novel_id', $novel_id)
                ->orderBy('chapter_id', 'desc')
                ->first();
            $novel->chpter_count = Chapter::where('novel_id', $novel_id)
                ->count();
        }
        return $novel;
    }

    public static function getCatalog($novel_id, $pageSize = 100, $page = 1)
    {
        $chapters = Chapter::where('novel_id', $novel_id)
            ->orderBy('chapter_id', 'asc')
            ->skip(($page - 1) * $pageSize)
            ->take($pageSize)
            ->get(['chapter_id', 'title', 'novel_id', 'is_free']);

        $total = Chapter::where('novel_id', $novel_id)->count();
        $data = [
            'chapters' => $chapters,
            'count' => $total,
            'page' => $page,
            'pageSize' => $pageSize
        ];
        return $data;
    }

    public static function getNovels($condition, $order = null, $pageSize = 10, $page = 1)
    {
        $novel = new Novel();
        if ($condition && is_array($condition)) {
            foreach ($condition as $key => $val) {
                // must filter able
                if (strpos($key, ' ')) {
                    $_arr = explode(' ', $key);
                    $k = $_arr[0];
                    $op = $_arr[1];
                    if (!in_array($k, self::$filterable)) {
                        continue;
                    }
                    if ($k && $op && in_array($op, ['>', '<', ">=", "<=", "=", 'like'])) {
                        $novel = $novel->where($k, $op, $val);
                    } elseif ($k && $op == 'in') {
                        $novel = $novel->whereIn($k, $val);
                    } else {
                        continue;
                    }
                } else {
                    if (in_array($key, self::$filterable)) {
                        $novel = $novel->where($key, $val);
                    }
                }
            }
        }

        if ($order && is_array($order)) {
            foreach ($order as $key => $val) {
                $novel = $novel->orderBy($key, $val);
            }
        }

        if ($page) {
            $novel = $novel->skip(($page - 1) * $pageSize);
            $novel = $novel->take($pageSize);
        }
        $novels = $novel->get();

        if ($novels) {
            foreach ($novels as $novel) {
                $novel->cover = env('APP_URL') . $novel->cover;
            }
        }

        return $novels;
    }

    public static function getCategories()
    {
        //$categories = Novel::select('category')->distinct('category')->get()->pluck('category');
        $categories = ["玄幻小说", "科幻小说", "网游小说", "穿越小说", "都市小说", "修真小说"];
        return $categories;
    }
}