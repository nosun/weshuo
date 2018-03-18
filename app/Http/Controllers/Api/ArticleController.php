<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Ajax;
use App\Http\Controllers\Controller;
use App\Models\Article;

class ArticleController extends Controller
{
    public function getArticle($id)
    {
        $article = Article::find($id);
        if(!$article){
            return Ajax::dataEmpty();
        }

        return Ajax::success($article);
    }
}
