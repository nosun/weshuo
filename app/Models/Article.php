<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $table = 'article';
    protected $fillable = ['cid', 'title', 'author', 'content', 'visible', 'weight'];
    public $timestamps = true;
}
