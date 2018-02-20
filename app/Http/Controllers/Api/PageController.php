<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Ajax;
use App\ModelHelpers\BannerHelper;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PageController extends Controller
{
    public function getIndexBanners()
    {
        $banners = BannerHelper::getBanners(3);

        if (empty($banners)) {
            return Ajax::dataEmpty();
        }

        return Ajax::success($banners);
    }
}
