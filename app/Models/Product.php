<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
     protected $fillable = [
        'categories_id',
        'subcategories_id',
        'maincategories_id',
        'units_id',
        'name',
        'product_id',
        'size',
        'color',
        'image',
        'description',
        'purchase_quantity',
        'unit',
        'purchase_price',
        'margin',
        'delivery_charge',
        'discount',
        'selling_price',
        'entered_by',
    ];
  
    /**
     * Set the user's first name.
     *
     * @param  string  $value
     * @return void
     */

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function userOne()
    {
        return $this->hasOne(User::class,'id','user_id');
    }

    public function setFilenamesAttribute($value)
    {
        $this->attributes['filenames'] = json_encode($value);
    }



public function subcategory()
    {
        return $this->belongsTo(Subcategory::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class,'categories_id');
    }


    public function units()
    {
        return $this->belongsTo(Unit::class);
    }

    
    public function maincategory()
    {
        return $this->belongsTo(MainCategory::class,'maincategories_id');
    }
    public function order()
    {
        return $this->belongsTo(Order::class,'product_id');
    }
    
}