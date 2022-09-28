<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;

    public function userOne()
    {
        return $this->hasOne(User::class,'id','user_id');
    }

    public function userRef()
    {
        return $this->hasOne(User::class,'id','ref_user_id');
    }
}