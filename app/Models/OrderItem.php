<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'product_id',
        'quantity',
        'price',
        'total',
        'is_gift',
        'gift_message',
        'wrapping_color',
        'gift_box_id',
        'gift_to',
        'gift_from'
    ];

    // Relationship with GiftBox
    public function giftBox()
    {
        return $this->belongsTo(GiftBox::class);
    }

    // Relationship with Order
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    // Relationship with Product
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
