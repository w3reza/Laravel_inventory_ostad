<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected  $fillable = [
        'user_id',
        'category_id',
        'name',
        'price',
        'unit',
        'description',
        'img_url'

    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
