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
        \Schema::disableForeignKeyConstraints();
        Product::truncate();
        \Schema::enableForeignKeyConstraints();


        $products = [
            // --- DEALS AND OFFERS ---
            [
                'name' => 'Smart watches',
                'price' => 19.00,
                'category' => 'Consumer electronics',
                'image' => 'images/tech/Smart-Watch.jpg',
                'is_deal' => true,
                'discount_percent' => 25,
            ],
            [
                'name' => 'Laptops',
                'price' => 340.00,
                'category' => 'Consumer electronics',
                'image' => 'images/tech/laptop.jpg',
                'is_deal' => true,
                'discount_percent' => 15,
            ],
            [
                'name' => 'GoPro cameras',
                'price' => 89.00,
                'category' => 'Consumer electronics',
                'image' => 'images/tech/GoPro-Camera.jpg',
                'is_deal' => true,
                'discount_percent' => 40,
            ],
            [
                'name' => 'Headphones',
                'price' => 10.00,
                'category' => 'Consumer electronics',
                'image' => 'images/tech/Gaming-Headset.jpg',
                'is_deal' => true,
                'discount_percent' => 25,
            ],
            [
                'name' => 'Smartphone',
                'price' => 19.00,
                'category' => 'Consumer electronics',
                'image' => 'images/tech/Smartphone.jpg',
                'is_deal' => true,
                'discount_percent' => 25,
            ],

            // --- HOME AND OUTDOOR ---
            [
                'name' => 'Soft Chairs',
                'price' => 19.00,
                'category' => 'Home and outdoor',
                'image' => 'images/interior/Armchair.jpg',
            ],
            [
                'name' => 'Table Lamp',
                'price' => 19.00,
                'category' => 'Home and outdoor',
                'image' => 'images/interior/Table-Lamp.jpg',
            ],
            [
                'name' => 'Air-Mattress',
                'price' => 19.00,
                'category' => 'Home and outdoor',
                'image' => 'images/interior/Air-Mattress.jpg',
            ],
            [
                'name' => 'Clay Pot',
                'price' => 19.00,
                'category' => 'Home and outdoor',
                'image' => 'images/interior/Clay-Pot.jpg',
            ],
            [
                'name' => 'Juicer',
                'price' => 100.00,
                'category' => 'Home and outdoor',
                'image' => 'images/interior/Juicer.jpg',
            ],
            [
                'name' => 'Coffee Maker',
                'price' => 39.00,
                'category' => 'Home and outdoor',
                'image' => 'images/interior/Coffee-Maker.jpg',
            ],
            [
                'name' => 'Rack',
                'price' => 19.00,
                'category' => 'Home and outdoor',
                'image' => 'images/interior/Rack.jpg',
            ],
            [
                'name' => 'Potted Plant',
                'price' => 10.00,
                'category' => 'Home and outdoor',
                'image' => 'images/interior/Potted-Plant.jpg',
            ],

            // --- CONSUMER ELECTRONICS ---
            [
                'name' => 'Smart Watches',
                'price' => 19.00,
                'category' => 'Consumer electronics',
                'image' => 'images/tech/Smart-Watch.jpg',
            ],
            [
                'name' => 'Cameras',
                'price' => 89.00,
                'category' => 'Consumer electronics',
                'image' => 'images/tech/GoPro-Camera.jpg',
            ],
            [
                'name' => 'Headphones',
                'price' => 10.00,
                'category' => 'Consumer electronics',
                'image' => 'images/tech/Headphones.jpg',
            ],
            [
                'name' => 'Electric kettle',
                'price' => 90.00,
                'category' => 'Consumer electronics',
                'image' => 'images/tech/Electric-Kettle.jpg',
            ],
            [
                'name' => 'Gaming set',
                'price' => 35.00,
                'category' => 'Consumer electronics',
                'image' => 'images/tech/Gaming-Headset.jpg',
            ],
            [
                'name' => 'Laptops & PC',
                'price' => 340.00,
                'category' => 'Consumer electronics',
                'image' => 'images/tech/Laptop.jpg',
            ],
            [
                'name' => 'Tablets',
                'price' => 19.00,
                'category' => 'Consumer electronics',
                'image' => 'images/tech/Tablet.jpg',
            ],
            [
                'name' => 'Smart Phones',
                'price' => 19.00,
                'category' => 'Consumer electronics',
                'image' => 'images/tech/iPhone.jpg',
            ],

            // --- RECOMMENDED ITEMS ---
            [
                'name' => 'T-shirts with multiple colors, for men',
                'price' => 10.30,
                'category' => 'Clothing',
                'image' => 'images/cloth/t-shirt.jpg',
                'is_recommended' => true,
            ],
            [
                'name' => 'Mens winter jacket, stylish brown color',
                'price' => 10.30,
                'category' => 'Clothing',
                'image' => 'images/cloth/jacket.jpg',
                'is_recommended' => true,
            ],
            [
                'name' => 'Casual blazer for men, formal fit',
                'price' => 10.30,
                'category' => 'Clothing',
                'image' => 'images/cloth/Blazer.jpg',
                'is_recommended' => true,
            ],
            [
                'name' => 'Genuine leather wallet for men, brown',
                'price' => 10.30,
                'category' => 'Clothing',
                'image' => 'images/cloth/leather-wallet.jpg',
                'is_recommended' => true,
            ],
            [
                'name' => 'Jeans bag for travel and daily use',
                'price' => 99.00,
                'category' => 'Clothing',
                'image' => 'images/cloth/jeans-bag.jpg',
                'is_recommended' => true,
            ],
            [
                'name' => 'Mens denim jeans shorts, summer style',
                'price' => 9.99,
                'category' => 'Clothing',
                'image' => 'images/cloth/jeans-shorts.jpg',
                'is_recommended' => true,
            ],
            [
                'name' => 'Headset for gaming with high-quality mic',
                'price' => 8.99,
                'category' => 'Consumer electronics',
                'image' => 'images/tech/headphones.jpg',
                'is_recommended' => true,
            ],
            [
                'name' => 'Hardcover book for reading and education',
                'price' => 2.50,
                'category' => 'Books',
                'image' => 'images/book/book.jpg',
                'is_recommended' => true,
            ],
            [
                'name' => 'Automatic washing machine, high efficiency',
                'price' => 40.30,
                'category' => 'Home and outdoor',
                'image' => 'images/interior/Washing-Machine.jpg',
                'is_recommended' => true,
            ],
            [
                'name' => 'Modern swivel office chair',
                'price' => 19.00,
                'category' => 'Home and outdoor',
                'image' => 'images/interior/Swivel-Chair.jpg',
                'is_recommended' => true,
            ],
        ];

        foreach ($products as $product) {
            Product::create([
                'name' => $product['name'],
                'slug' => Str::slug($product['name']) . '-' . Str::random(5),
                'sku' => strtoupper(Str::random(8)),
                'description' => 'This is a high-quality ' . $product['name'] . ' from the ' . $product['category'] . ' category.',
                'price' => $product['price'],
                'category' => $product['category'],
                'image' => $product['image'],
                'stock_quantity' => rand(10, 100),
                'status' => 'active',
                'is_recommended' => $product['is_recommended'] ?? false,
                'is_deal' => $product['is_deal'] ?? false,
                'discount_percent' => $product['discount_percent'] ?? null,
            ]);
        }
    }

}
