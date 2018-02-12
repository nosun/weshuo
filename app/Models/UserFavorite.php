<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserFavorite extends Model
{
    protected  $table = 'user_favorite';
    protected  $fillable = ['user_id','novel_id','created_at'];
    public $timestamps = false;
}
