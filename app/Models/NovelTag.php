<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NovelTag extends Model
{
    protected  $table = 'novel_tag';
    protected  $fillable = ['novel_id','tag_id'];
    public $timestamps = true;


}
