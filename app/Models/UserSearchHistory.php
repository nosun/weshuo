<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserSearchHistory extends Model
{
    protected  $table = 'user_search_history';
    protected  $fillable = ['user_id','keyword','created_at'];
    public $timestamps = false;
}
