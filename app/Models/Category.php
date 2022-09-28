<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $table='categories';

    // protected $fillable = [
    //     'user_id'
    // ];

 public function user()
    {
        return $this->belongsTo(User::class);
    }

public function subcategory()
    {
        return $this->belongsTo(Subcategory::class);
    }

    public function products()
    {
    return $this->belongsTo(Product::class);
    }

    public function units()
    {
    return $this->belongsToMany(Unit::class);
    }
    
}
