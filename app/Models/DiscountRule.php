<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DiscountRule extends Model
{
    use HasFactory;

    /**
     * The "booted" method of the model.
     */
    protected static function booted()
    {
        static::saving(function ($rule) {
            if ($rule->is_active) {
                // Deactivate all other rules
                self::where('id', '!=', $rule->id)->update(['is_active' => false]);
            }
        });
    }

    protected $fillable = [
        'name',
        'min_amount',
        'discount_value',
        'type',
        'is_active',
    ];

    /**
     * Get the currently active discount rule.
     */
    public static function active()
    {
        return self::where('is_active', true)->first();
    }

    /**
     * Calculate discount for a given subtotal.
     */
    public function calculateDiscount($subtotal, $userId = null)
    {
        if ($subtotal < $this->min_amount) {
            return 0;
        }

        // Only for new users (first order)
        if ($userId) {
            $hasPreviousOrders = \App\Models\Order::where('user_id', $userId)->exists();
            if ($hasPreviousOrders) {
                return 0;
            }
        }

        if ($this->type === 'percentage') {
            return $subtotal * ($this->discount_value / 100);
        }

        return min($this->discount_value, $subtotal); // Fixed discount cannot exceed subtotal
    }
}
