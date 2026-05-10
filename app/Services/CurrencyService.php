<?php

namespace App\Services;

class CurrencyService
{
    public static function getRates()
    {
        return [
            'USD' => ['rate' => 1, 'symbol' => '$', 'position' => 'before'],
            'AED' => ['rate' => 3.67, 'symbol' => 'د.إ', 'position' => 'after'],
            'PKR' => ['rate' => 278, 'symbol' => 'Rs.', 'position' => 'before'],
        ];
    }

    public static function convert($amount)
    {
        $currency = session('currency', 'USD');
        $rates = self::getRates();
        $rate = $rates[$currency]['rate'] ?? 1;
        $symbol = $rates[$currency]['symbol'] ?? '$';
        $position = $rates[$currency]['position'] ?? 'before';

        $converted = $amount * $rate;
        
        // Formatting
        if ($position === 'before') {
            return $symbol . ' ' . number_format($converted, 2);
        } else {
            return number_format($converted, 2) . ' ' . $symbol;
        }
    }

    public static function getCurrentCurrency()
    {
        return session('currency', 'USD');
    }
}
