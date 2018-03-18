<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected  $table = 'user';
    protected  $fillable = ['openid','nickname','language','country','province','avatar','gender'];
    public $timestamps = true;

    public function account(){
        return $this->hasMany('user_account','user_id','id');
    }

    public function searchHistory(){
        return $this->hasMany('user_search_history','user_id','id');
    }

    public function readingHistory(){
        return $this->hasMany('user_reading_history','user_id','id');
    }

    public function novels(){
        return $this->hasMany('user_novel','user_id','id');
    }

    public function favorite(){
        return $this->hasMany('user_favorite','user_id','id');
    }

    public function transaction(){
        return $this->hasMany('user_transaction','user_id','id');
    }
}
