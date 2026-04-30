<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // Drop old columns if they exist but we don't need them, though usually we can just leave them
            // However, to match strictly, let's rename stock to stock_quantity if it exists
            if (Schema::hasColumn('products', 'stock') && !Schema::hasColumn('products', 'stock_quantity')) {
                $table->renameColumn('stock', 'stock_quantity');
            }

            if (!Schema::hasColumn('products', 'sku')) {
                $table->string('sku')->nullable()->unique()->after('slug');
            }
            if (!Schema::hasColumn('products', 'compare_price')) {
                $table->decimal('compare_price', 10, 2)->nullable()->after('price');
            }
            if (!Schema::hasColumn('products', 'features')) {
                $table->text('features')->nullable()->after('description');
            }
            if (!Schema::hasColumn('products', 'status')) {
                $table->string('status')->default('active')->after('features');
            }
            if (!Schema::hasColumn('products', 'views')) {
                $table->integer('views')->default(0)->after('status');
            }
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['sku', 'compare_price', 'features', 'status', 'views']);
            if (Schema::hasColumn('products', 'stock_quantity')) {
                $table->renameColumn('stock_quantity', 'stock');
            }
        });
    }
};
