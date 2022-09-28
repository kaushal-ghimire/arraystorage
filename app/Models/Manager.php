<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Manager extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'address',
        'role',
    ];
    public function order_details()
    {
    return $this->belongsTo(OrderDetails::class);
    }

    public function order()
    {
    return $this->belongsToMany(Order::class);
    }
   }
