<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    use HasFactory;
    public function user()
    {
        return $this->belongsTo(User::class);
    }

      public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }
    public function getProduct()
    {
        return $this->belongsTo(Product::class,'id','product_id');
    }
    protected $fillable = [
        'bill',
        'purchase'
        

    ];
}