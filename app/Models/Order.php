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
        'payment_method',
        'shipping_address',
        'shipping_phone',
        'stripe_session_id',
        'subtotal',
        'shipping_cost',
        'tax',
        'notes',
        'email',
        'postal_code',
        'country',
        'state'
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

    // Relationship with Transactions
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    // Generate order number
    public static function generateOrderNumber()
    {
        return 'ORD-' . strtoupper(uniqid()) . date('Ymd');
    }
}
