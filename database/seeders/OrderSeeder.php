<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::where('email', 'test@example.com')->first();
        if (!$user) {
            return;
        }

        $products = Product::limit(10)->get();

        for ($i = 0; $i < 3; $i++) {
            $orderProducts = $products->random(rand(1, 3));
            $subtotal = 0;
            
            foreach ($orderProducts as $product) {
                $subtotal += $product->price * rand(1, 2);
            }

            $order = Order::create([
                'user_id' => $user->id,
                'order_number' => 'ORD-' . strtoupper(Str::random(10)),
                'subtotal' => $subtotal,
                'tax' => $subtotal * 0.05,
                'shipping_cost' => 10.00,
                'total_amount' => $subtotal + ($subtotal * 0.05) + 10.00,
                'shipping_phone' => '1234567890',
                'shipping_address' => '123 Test Street, Test City',
                'email' => $user->email,
                'country' => 'Pakistan',
                'state' => 'Punjab',
                'postal_code' => '54000',
                'status' => ['pending', 'processing', 'shipped', 'delivered', 'cancelled'][rand(0, 4)],
                'payment_status' => ['paid', 'pending', 'failed'][rand(0, 2)],
            ]);

            foreach ($orderProducts as $product) {
                $qty = rand(1, 2);
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'quantity' => $qty,
                    'price' => $product->price,
                    'total' => $product->price * $qty,
                ]);
            }
        }
    }
}
