<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GiftBox extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'base_price',
        'description',
        'image',
        'status'
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class, 'gift_box_contents');
    }
}
