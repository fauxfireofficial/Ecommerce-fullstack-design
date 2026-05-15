<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->decimal('shipping_fee_national', 8, 2)->default(0)->after('is_free_shipping');
            $table->decimal('shipping_fee_international', 8, 2)->default(0)->after('shipping_fee_national');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['shipping_fee_national', 'shipping_fee_international']);
        });
    }
};
