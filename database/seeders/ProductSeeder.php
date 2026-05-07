<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run()
    {
        // Clear existing products
        \Illuminate\Support\Facades\Schema::disableForeignKeyConstraints();
        Product::truncate();
        \Illuminate\Support\Facades\Schema::enableForeignKeyConstraints();

        $products = [
            // --- 1. MOBILE AND TABLETS ---
            ['name' => 'iPhone 15 Pro', 'price' => 999.00, 'category' => 'Mobile and Tablets', 'image' => 'images/tech/iPhone.jpg'],
            ['name' => 'Samsung Galaxy S24', 'price' => 899.00, 'category' => 'Mobile and Tablets', 'image' => 'images/tech/Smartphone.jpg'],
            ['name' => 'iPad Air (M2)', 'price' => 599.00, 'category' => 'Mobile and Tablets', 'image' => 'images/tech/Tablet.jpg'],
            ['name' => 'Android Tablet 10"', 'price' => 249.00, 'category' => 'Mobile and Tablets', 'image' => 'images/tech/Tablet.jpg'],
            ['name' => 'Power Bank 20000mAh', 'price' => 45.00, 'category' => 'Mobile and Tablets', 'image' => 'images/tech/Smart-Watch.jpg'],
            ['name' => 'Silicone Mobile Case', 'price' => 15.00, 'category' => 'Mobile and Tablets', 'image' => 'images/tech/Smart-Watch.jpg'],
            ['name' => 'Fast Charging Cable', 'price' => 12.00, 'category' => 'Mobile and Tablets', 'image' => 'images/tech/Smart-Watch.jpg'],

            // --- 2. COMPUTER AND TECH ---
            ['name' => 'Gaming Laptop RTX 4060', 'price' => 1200.00, 'category' => 'Computer and tech', 'image' => 'images/tech/laptop.jpg'],
            ['name' => 'MacBook Air M3', 'price' => 1099.00, 'category' => 'Computer and tech', 'image' => 'images/tech/laptop.jpg'],
            ['name' => 'Desktop PC i7', 'price' => 850.00, 'category' => 'Computer and tech', 'image' => 'images/tech/laptop.jpg'],
            ['name' => 'PlayStation 5', 'price' => 499.00, 'category' => 'Computer and tech', 'image' => 'images/tech/GoPro-Camera.jpg'],
            ['name' => '27" 4K Monitor', 'price' => 320.00, 'category' => 'Computer and tech', 'image' => 'images/tech/Tablet.jpg'],
            ['name' => 'Mechanical Keyboard', 'price' => 75.00, 'category' => 'Computer and tech', 'image' => 'images/tech/Gaming-Headset.jpg'],
            ['name' => 'Wireless Mouse', 'price' => 30.00, 'category' => 'Computer and tech', 'image' => 'images/tech/Smartphone.jpg'],
            ['name' => 'Wireless Headphones', 'price' => 150.00, 'category' => 'Computer and tech', 'image' => 'images/tech/Headphones.jpg'],

            // --- 3. CLOTHES AND WEAR ---
            ['name' => 'Graphic T-shirt', 'price' => 25.00, 'category' => 'Clothes and wear', 'image' => 'images/cloth/t-shirt.jpg'],
            ['name' => 'Slim Fit Jeans', 'price' => 45.00, 'category' => 'Clothes and wear', 'image' => 'images/cloth/jeans-shorts.jpg'],
            ['name' => 'Winter Bomber Jacket', 'price' => 85.00, 'category' => 'Clothes and wear', 'image' => 'images/cloth/jacket.jpg'],
            ['name' => 'Formal White Shirt', 'price' => 35.00, 'category' => 'Clothes and wear', 'image' => 'images/cloth/Blazer.jpg'],
            ['name' => 'Casual Hoodie', 'price' => 50.00, 'category' => 'Clothes and wear', 'image' => 'images/cloth/jacket.jpg'],
            ['name' => 'Summer Floral Dress', 'price' => 60.00, 'category' => 'Clothes and wear', 'image' => 'images/cloth/t-shirt.jpg'],
            ['name' => 'Classic Analog Watch', 'price' => 120.00, 'category' => 'Clothes and wear', 'image' => 'images/tech/Smart-Watch.jpg'],
            ['name' => 'Running Sneakers', 'price' => 90.00, 'category' => 'Clothes and wear', 'image' => 'images/cloth/jeans-bag.jpg'],

            // --- 4. HOME INTERIORS ---
            ['name' => 'Cotton Bed Sheets', 'price' => 40.00, 'category' => 'Home interiors', 'image' => 'images/interior/Air-Mattress.jpg'],
            ['name' => 'Velvet Curtains', 'price' => 55.00, 'category' => 'Home interiors', 'image' => 'images/interior/Rack.jpg'],
            ['name' => 'Modern Wall Art', 'price' => 30.00, 'category' => 'Home interiors', 'image' => 'images/interior/Clay-Pot.jpg'],
            ['name' => 'Designer Table Lamp', 'price' => 45.00, 'category' => 'Home interiors', 'image' => 'images/interior/Table-Lamp.jpg'],
            ['name' => 'Coffee Table', 'price' => 110.00, 'category' => 'Home interiors', 'image' => 'images/interior/Armchair.jpg'],
            ['name' => 'Kitchen Blender', 'price' => 65.00, 'category' => 'Home interiors', 'image' => 'images/interior/Juicer.jpg'],
            ['name' => 'Crockery Set (24pc)', 'price' => 130.00, 'category' => 'Home interiors', 'image' => 'images/interior/Coffee-Maker.jpg'],

            // --- 5. TOOLS AND EQUIPMENTS ---
            ['name' => 'Electric Drill Machine', 'price' => 85.00, 'category' => 'Tools, equipments', 'image' => 'images/interior/Juicer.jpg'],
            ['name' => 'Screwdriver Set', 'price' => 20.00, 'category' => 'Tools, equipments', 'image' => 'images/interior/Rack.jpg'],
            ['name' => 'Measuring Tape (5m)', 'price' => 10.00, 'category' => 'Tools, equipments', 'image' => 'images/interior/Clay-Pot.jpg'],
            ['name' => 'Heavy Duty Gloves', 'price' => 15.00, 'category' => 'Tools, equipments', 'image' => 'images/cloth/jacket.jpg'],
            ['name' => 'Portable Toolbox', 'price' => 40.00, 'category' => 'Tools, equipments', 'image' => 'images/interior/Rack.jpg'],
            ['name' => 'LED Flashlight', 'price' => 18.00, 'category' => 'Tools, equipments', 'image' => 'images/tech/GoPro-Camera.jpg'],

            // --- 6. HEALTH AND BEAUTY ---
            ['name' => 'Skincare Serum', 'price' => 35.00, 'category' => 'Health and Beauty', 'image' => 'images/interior/Table-Lamp.jpg'],
            ['name' => 'Luxury Perfume', 'price' => 150.00, 'category' => 'Health and Beauty', 'image' => 'images/tech/Smart-Watch.jpg'],
            ['name' => 'Ionic Hair Dryer', 'price' => 45.00, 'category' => 'Health and Beauty', 'image' => 'images/tech/GoPro-Camera.jpg'],
            ['name' => 'Beard Trimmer', 'price' => 30.00, 'category' => 'Health and Beauty', 'image' => 'images/tech/Smartphone.jpg'],
            ['name' => 'Multivitamin Caps', 'price' => 25.00, 'category' => 'Health and Beauty', 'image' => 'images/interior/Clay-Pot.jpg'],

            // --- 7. SPORTS AND OUTDOOR ---
            ['name' => 'Dumbbells Set (10kg)', 'price' => 60.00, 'category' => 'Sports and outdoor', 'image' => 'images/tech/GoPro-Camera.jpg'],
            ['name' => 'Yoga Mat', 'price' => 20.00, 'category' => 'Sports and outdoor', 'image' => 'images/interior/Air-Mattress.jpg'],
            ['name' => 'English Willow Bat', 'price' => 120.00, 'category' => 'Sports and outdoor', 'image' => 'images/interior/Rack.jpg'],
            ['name' => 'Official Football', 'price' => 25.00, 'category' => 'Sports and outdoor', 'image' => 'images/tech/Tablet.jpg'],
            ['name' => 'Camping Tent (4P)', 'price' => 180.00, 'category' => 'Sports and outdoor', 'image' => 'images/tech/GoPro-Camera.jpg'],

            // --- 8. ACCESSORIES ---
            ['name' => 'Leather Wallet', 'price' => 35.00, 'category' => 'Accessories', 'image' => 'images/cloth/leather-wallet.jpg'],
            ['name' => 'Designer Belt', 'price' => 25.00, 'category' => 'Accessories', 'image' => 'images/cloth/jeans-bag.jpg'],
            ['name' => 'School Backpack', 'price' => 45.00, 'category' => 'Accessories', 'image' => 'images/cloth/jeans-bag.jpg'],
            ['name' => 'Golden Bracelet', 'price' => 200.00, 'category' => 'Accessories', 'image' => 'images/tech/Smart-Watch.jpg'],

            // --- DEALS ---
            [
                'name' => 'Laptops',
                'price' => 340.00,
                'category' => 'Computer and tech',
                'image' => 'images/tech/laptop.jpg',
                'is_deal' => true,
                'discount_percent' => 15,
            ],
            [
                'name' => 'Smart watches',
                'price' => 19.00,
                'category' => 'Computer and tech',
                'image' => 'images/tech/Smart-Watch.jpg',
                'is_deal' => true,
                'discount_percent' => 25,
            ],
        ];

        foreach ($products as $item) {
            Product::create([
                'name' => $item['name'],
                'slug' => Str::slug($item['name']) . '-' . uniqid(),
                'sku' => 'SKU-' . strtoupper(Str::random(8)),
                'price' => $item['price'],
                'compare_price' => $item['price'] * 1.2,
                'stock_quantity' => rand(10, 100),
                'category' => $item['category'],
                'image' => $item['image'],
                'description' => 'This is a high-quality ' . $item['name'] . ' from the ' . $item['category'] . ' category.',
                'features' => "Premium quality\nDurable material\nBest in class performance",
                'status' => 'active',
                'is_recommended' => isset($item['is_recommended']) ? $item['is_recommended'] : (rand(1, 10) > 7),
                'is_deal' => $item['is_deal'] ?? false,
                'discount_percent' => $item['discount_percent'] ?? 0,
                'views' => rand(100, 5000),
                'brand' => 'Brand-' . rand(1, 5),
            ]);
        }
    }
}
