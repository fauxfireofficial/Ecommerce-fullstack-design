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
            $table->string('brand')->nullable()->after('name');
            $table->decimal('weight', 8, 2)->nullable()->after('price');
            $table->string('dimensions')->nullable()->after('weight');
            $table->json('colors')->nullable()->after('features');
            $table->json('sizes')->nullable()->after('colors');
            $table->json('materials')->nullable()->after('sizes');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['brand', 'weight', 'dimensions', 'colors', 'sizes', 'materials']);
        });
    }
};
