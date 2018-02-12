<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserTransaction extends Model
{
    protected  $table = 'user_transaction';
    protected  $fillable = ['user_id','type','amount','status','detail'];
    public $timestamps = true;
}
