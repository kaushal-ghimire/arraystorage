<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShippingAddress extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'name',
        'address',
        'map_address',
        'city',
        'phone_no',
        'status',
    ];
    public function getUser()
    {
        return $this->hasOne(User::class,'id','user_id');
    }

}
