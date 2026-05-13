<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class SyncProductSoldCount extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'products:sync-sold';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Synchronize sold_count for all products based on order items';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $products = \App\Models\Product::all();
        $this->info('Starting synchronization for ' . $products->count() . ' products...');

        foreach ($products as $product) {
            $soldCount = \App\Models\OrderItem::where('product_id', $product->id)->sum('quantity');
            $product->sold_count = $soldCount;
            $product->save();
        }

        $this->info('Sold count synchronization completed successfully!');
    }
}
