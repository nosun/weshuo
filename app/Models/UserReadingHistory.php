<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserReadingHistory extends Model
{
    protected  $table = 'user_reading_history';
    protected  $fillable = ['user_id','novel_id','chapter_id','created_at'];
    public $timestamps = false;
}
