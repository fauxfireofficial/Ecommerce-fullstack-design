<?php

namespace Database\Seeders;

use App\Models\DiscountRule;
use Illuminate\Database\Seeder;

class DiscountRuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DiscountRule::truncate(); // Clear existing
        DiscountRule::create([
            'name' => 'First Order Special',
            'min_amount' => 1000.00,
            'discount_value' => 100.00,
            'type' => 'fixed',
            'is_active' => true,
        ]);
    }
}
