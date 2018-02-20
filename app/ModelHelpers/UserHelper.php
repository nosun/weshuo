<?php

namespace App\ModelHelpers;

use App\Models\Chapter;
use App\Models\Novel;

class UserHelper
{
    public static function getUserLastRead($uid){
        $chapter = Chapter::find(1);
        return $chapter;
    }
}