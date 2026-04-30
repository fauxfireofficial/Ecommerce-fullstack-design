<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateOrdersAndOrderItemsTables extends Migration
{
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            // Drop old columns if they exist
            if (Schema::hasColumn('orders', 'phone_number')) {
                $table->dropColumn('phone_number');
            }
            if (Schema::hasColumn('orders', 'address')) {
                $table->dropColumn('address');
            }
            if (Schema::hasColumn('orders', 'city')) {
                $table->dropColumn('city');
            }
            if (Schema::hasColumn('orders', 'payment_method')) {
                $table->dropColumn('payment_method');
            }

            // Add new columns if they don't exist
            if (!Schema::hasColumn('orders', 'payment_status')) {
                $table->string('payment_status')->default('pending')->after('status');
            }
            if (!Schema::hasColumn('orders', 'shipping_address')) {
                $table->text('shipping_address')->nullable()->after('payment_status');
            }
            if (!Schema::hasColumn('orders', 'shipping_phone')) {
                $table->string('shipping_phone')->nullable()->after('shipping_address');
            }
            if (!Schema::hasColumn('orders', 'subtotal')) {
                $table->decimal('subtotal', 10, 2)->default(0)->after('shipping_phone');
            }
            if (!Schema::hasColumn('orders', 'shipping_cost')) {
                $table->decimal('shipping_cost', 10, 2)->default(0)->after('subtotal');
            }
            if (!Schema::hasColumn('orders', 'tax')) {
                $table->decimal('tax', 10, 2)->default(0)->after('shipping_cost');
            }
            if (!Schema::hasColumn('orders', 'notes')) {
                $table->text('notes')->nullable()->after('tax');
            }
            
            // Change user_id to nullable if it's not
            $table->foreignId('user_id')->nullable()->change();
            
            // Change status from enum to string if it was enum
            $table->string('status')->default('pending')->change();
        });

        Schema::table('order_items', function (Blueprint $table) {
            if (!Schema::hasColumn('order_items', 'total')) {
                $table->decimal('total', 10, 2)->after('price');
            }
            // Make product_id nullable
            $table->foreignId('product_id')->nullable()->change();
        });
    }

    public function down()
    {
        // Reverting would be complex, usually not needed for this kind of task unless specified
    }
}
