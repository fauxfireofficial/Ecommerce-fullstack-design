<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'transaction_id',
        'payment_method',
        'amount',
        'currency',
        'status',
        'metadata',
    ];

    protected $casts = [
        'metadata' => 'array',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
