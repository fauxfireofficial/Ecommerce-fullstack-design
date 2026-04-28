<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            [
                'name' => 'Canon EOS M50 Mark II',
                'price' => 599.00,
                'category' => 'Consumer Electronics',
                'image' => 'Images/items/1.png',
            ],
            [
                'name' => 'Samsung Galaxy Watch 4',
                'price' => 249.99,
                'category' => 'Consumer Electronics',
                'image' => 'Images/items/2.png',
            ],
            [
                'name' => 'Sony WH-1000XM4 Headphones',
                'price' => 348.00,
                'category' => 'Consumer Electronics',
                'image' => 'Images/items/3.png',
            ],
            [
                'name' => 'Apple iPad Air (2022)',
                'price' => 559.00,
                'category' => 'Consumer Electronics',
                'image' => 'Images/items/4.png',
            ],
            [
                'name' => 'Modern Sofa Set',
                'price' => 1200.00,
                'category' => 'Home and Outdoor',
                'image' => 'Images/items/5.png',
            ],
            [
                'name' => 'Outdoor Dining Table',
                'price' => 450.00,
                'category' => 'Home and Outdoor',
                'image' => 'Images/items/6.png',
            ],
            [
                'name' => 'Ergonomic Office Chair',
                'price' => 180.00,
                'category' => 'Home and Outdoor',
                'image' => 'Images/items/7.png',
            ],
            [
                'name' => 'Smart LED TV 55 Inch',
                'price' => 699.00,
                'category' => 'Consumer Electronics',
                'image' => 'Images/items/8.png',
            ],
            [
                'name' => 'Gaming Laptop RTX 3060',
                'price' => 1150.00,
                'category' => 'Consumer Electronics',
                'image' => 'Images/items/9.png',
            ],
            [
                'name' => 'Kitchen Blender Pro',
                'price' => 85.00,
                'category' => 'Home and Outdoor',
                'image' => 'Images/items/10.png',
            ],
        ];

        foreach ($products as $product) {
            Product::create([
                'name' => $product['name'],
                'slug' => Str::slug($product['name']),
                'description' => 'This is a high-quality ' . $product['name'] . ' from the ' . $product['category'] . ' category.',
                'price' => $product['price'],
                'category' => $product['category'],
                'image' => $product['image'],
                'stock' => rand(10, 50),
                'is_featured' => rand(0, 1),
            ]);
        }
    }
}
