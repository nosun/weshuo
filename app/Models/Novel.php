<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Novel extends Model
{
    protected  $table = 'novel';
    protected  $fillable = ['name','author','sn','description','cover','category',
        'status','hot','elite','is_free','free_chapters','price','source_url'];
    public $timestamps = true;
}
