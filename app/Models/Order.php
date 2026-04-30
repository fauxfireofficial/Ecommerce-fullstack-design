<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'order_number',
        'total_amount',
        'status',
        'payment_status',
        'shipping_address',
        'shipping_phone',
        'subtotal',
        'shipping_cost',
        'tax',
        'notes'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relationship with User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relationship with Order Items
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    // Generate order number
    public static function generateOrderNumber()
    {
        return 'ORD-' . strtoupper(uniqid()) . date('Ymd');
    }
}
