<?php

namespace App\ModelHelpers;

use App\Models\Chapter;
use App\Models\Novel;

class NovelHelper
{
    public static function getChapter($novel_id, $chapter_id)
    {
        $chapter = Chapter::where('novel_id', $novel_id)
            ->where('chapter_id', $chapter_id)
            ->first();
        return $chapter;
    }

    public static function getNovel($novel_id)
    {
        return Novel::find($novel_id);
    }

    public static function getCatalog($novel_id)
    {
        return Chapter::where('novel_id', $novel_id)
            ->orderBy('chapter_id', 'asc')
            ->get(['chapter_id', 'title']);
    }

    public static function getNovels($condition, $order, $pageSize = 10, $page = 1)
    {
        $novel = new Novel();
        if ($condition && is_array($condition)) {
            foreach ($condition as $key => $val) {
                if (strpos($key, ' ')) {
                    $_arr = explode(' ', $key);
                    $k = $_arr[0];
                    $op = $_arr[1];
                    if ($k && $op && in_array($op, ['>', '<', ">=", "<=", "=", 'like'])) {
                        $novel = $novel->where($k, $op, $val);
                    } else {
                        continue;
                    }
                } else {
                    $novel = $novel->where($key, $val);
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

        return $novel->get();
    }
}