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
        Schema::table('supplier_inquiries', function (Blueprint $table) {
            $table->foreignId('product_id')->nullable()->after('user_id')->constrained()->nullOnDelete();
            $table->renameColumn('item_name', 'custom_item_name');
        });
        
        Schema::table('supplier_inquiries', function (Blueprint $table) {
            $table->string('custom_item_name')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('supplier_inquiries', function (Blueprint $table) {
            $table->dropForeign(['product_id']);
            $table->dropColumn('product_id');
            $table->string('custom_item_name')->nullable(false)->change();
            $table->renameColumn('custom_item_name', 'item_name');
        });
    }
};
