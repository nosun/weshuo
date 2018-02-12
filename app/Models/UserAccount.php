<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserAccount extends Model
{
    protected  $table = 'user_account';
    protected  $fillable = ['user_id','point','change','detail','novel_id','type'];
    public $timestamps = true;

    public function user(){
        return $this->belongsTo('user','user_id','id');
    }
}
