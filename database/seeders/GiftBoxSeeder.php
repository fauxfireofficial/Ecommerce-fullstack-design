<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\GiftBox;

class GiftBoxSeeder extends Seeder
{
    public function run(): void
    {
        GiftBox::create([
            'name' => 'Birthday Surprise Box',
            'slug' => 'birthday-surprise-box',
            'base_price' => 35.00,
            'description' => 'A wonderful gift box for birthdays.',
            'image' => 'images/products/gift1.jpg',
            'status' => 'active'
        ]);

        GiftBox::create([
            'name' => 'Corporate Elegance Box',
            'slug' => 'corporate-elegance-box',
            'base_price' => 50.00,
            'description' => 'Professional gift box for colleagues.',
            'image' => 'images/products/gift2.jpg',
            'status' => 'active'
        ]);

        GiftBox::create([
            'name' => 'Wedding Harmony Box',
            'slug' => 'wedding-harmony-box',
            'base_price' => 75.00,
            'description' => 'Luxury gift box for weddings.',
            'image' => 'images/products/gift3.jpg',
            'status' => 'active'
        ]);
    }
}
