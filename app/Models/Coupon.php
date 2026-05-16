<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Coupon extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'type',
        'value',
        'min_purchase',
        'usage_limit',
        'used_count',
        'expires_at',
        'is_active',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
        'is_active' => 'boolean',
    ];

    /**
     * Check if the coupon is valid for a given subtotal and user.
     */
    public function isValid($subtotal, $userId = null)
    {
        if (!$this->is_active) {
            return [false, 'This coupon is inactive.'];
        }

        if ($this->expires_at && $this->expires_at->isPast()) {
            return [false, 'This coupon has expired.'];
        }

        if ($subtotal < $this->min_purchase) {
            return [false, 'Minimum purchase of ' . $this->min_purchase . ' required.'];
        }

        if ($this->usage_limit && $this->used_count >= $this->usage_limit) {
            return [false, 'This coupon usage limit has been reached.'];
        }

        if ($userId) {
            $alreadyUsed = Order::where('user_id', $userId)
                ->where('coupon_id', $this->id)
                ->exists();
            if ($alreadyUsed) {
                return [false, 'You have already used this coupon once.'];
            }
        }

        return [true, null];
    }

    /**
     * Calculate discount amount.
     */
    public function calculateDiscount($subtotal)
    {
        if ($this->type === 'percentage') {
            return $subtotal * ($this->value / 100);
        }

        return min($this->value, $subtotal);
    }
}
