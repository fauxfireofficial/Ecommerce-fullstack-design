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
            if (!Schema::hasColumn('products', 'is_recommended')) {
                $table->boolean('is_recommended')->default(false)->after('status');
            }
            if (!Schema::hasColumn('products', 'is_deal')) {
                $table->boolean('is_deal')->default(false)->after('is_recommended');
            }
            if (!Schema::hasColumn('products', 'discount_percent')) {
                $table->integer('discount_percent')->nullable()->after('is_deal');
            }
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['is_recommended', 'is_deal', 'discount_percent']);
        });
    }

};
