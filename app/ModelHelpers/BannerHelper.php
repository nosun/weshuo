<?php

namespace App\ModelHelpers;

use App\Models\Banner;

class BannerHelper
{
    public static function getBanners($num=3)
    {
        $banners = Banner::where('visible', 1)->orderBy('weight','desc')->take($num)->get();
        return $banners;
    }
}