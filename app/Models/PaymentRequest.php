<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentRequest extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'amount',
        'status',
    ];

    public function getUser()
    {
        return $this->hasOne(User::class,'id','user_id');
    }
    public function getPaymentRequest()
    {
        return $this->hasOne(Order::class,'id','confirmed_by');
    }
}
