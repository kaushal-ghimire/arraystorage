<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MainCategory extends Model
{
    use HasFactory;

    protected $table = 'maincategories';
    protected $fillable = [
        'id',
        'name',
        'image'
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

}