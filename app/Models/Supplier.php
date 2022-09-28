<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
     protected $fillable = [
        'name',
        'business_id',
        'phone',
        'address',
        'pan',
        'date'

    ];
}