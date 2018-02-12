<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Chapter extends Model
{
    protected  $table = 'chapter';
    protected  $fillable = ['novel_id','title','content','views'];
    public $timestamps = true;
}
