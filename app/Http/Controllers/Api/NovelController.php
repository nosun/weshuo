<?php

namespace App\Http\Controllers\Api;

use App\ModelHelpers\NovelHelper;
use App\ModelHelpers\UserHelper;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Helpers\Ajax;
use Illuminate\Support\Facades\Redis;

class NovelController extends Controller
{

    /*
     * 获取小说列表
     *
     * */
    public function getNovels(Request $request)
    {
        $condition = $request->input('condition', []);
        $pageSize = $request->input('pageSize', 10);
        $page = $request->input('page', 1);
        $order = $request->input('order', ['updated_at' => 'desc']);

        $novels = NovelHelper::getNovels($condition, $order, $pageSize, $page);

        if (empty($novels)) {
            return Ajax::dataEmpty();
        }

        return Ajax::success($novels);
    }

    /*
     * 获取小说
     *
     * */
    public function getNovel(Request $request, $novel_id)
    {
        if (empty($novel_id)) {
            return Ajax::argumentsError();
        }

        $novel = NovelHelper::getNovel($request->user->id, $novel_id);

        if (empty($novel)) {
            return Ajax::dataEmpty();
        }

        return Ajax::success($novel);
    }

    /*
     * 获取目录
     *
     * */
    public function getCatalog($novel_id)
    {
        if (empty($novel_id)) {
            Ajax::argumentsError();
        }

        $catalog = NovelHelper::getCatalog($novel_id);

        if (empty($catalog)) {
            Ajax::dataEmpty();
        }

        return Ajax::success($catalog);
    }

    /*
     * 获取小说章节
     *
     * */
    public function getChapter($novel_id, $chapter_id, Request $request)
    {
        if (empty($novel_id) || empty($chapter_id)) {
            return Ajax::argumentsError();
        }

        $chapter = NovelHelper::getChapter($novel_id, $chapter_id);

        if (empty($chapter)) {
            return Ajax::dataEmpty();
        }

        // check is_free and has already buy the novel
        if ($chapter->is_free !== 1 and
            $this->checkPermission($request->user->id, $chapter->novel_id) !== true
        ) {
            return Ajax::forbidden();
        }

        UserHelper::addToUserReadingHistory($request->user->id, $chapter->novel_id, $chapter->chapter_id);

        return Ajax::success($chapter);
    }

    public function checkPermission($uid, $novel_id)
    {
        return false;
    }

    public function getCategories()
    {
        $categories = NovelHelper::getCategories();

        if (empty($categories)) {
            return Ajax::dataEmpty();
        }

        return Ajax::success($categories);
    }
}
