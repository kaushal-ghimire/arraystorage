<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    public function getProduct()
    {
        return $this->hasOne(Product::class,'id','product_id');
    }

    public function getUser()
    {
        return $this->hasOne(User::class,'id','user_id');
    }

      public function product()
    {
        return $this->belongsTo(Product::class,'product_id','id');
    }
 
}
