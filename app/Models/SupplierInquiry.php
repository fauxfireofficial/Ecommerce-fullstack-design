<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SupplierInquiry extends Model
{
    protected $fillable = [
        'user_id',
        'product_id',
        'custom_item_name',
        'details',
        'quantity',
        'unit',
        'status',
        'admin_notes',
        'offered_price',
        'admin_message',
        'user_reply',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
