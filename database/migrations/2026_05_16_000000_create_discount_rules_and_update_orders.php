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
        Schema::create('discount_rules', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->decimal('min_amount', 10, 2);
            $table->decimal('discount_value', 10, 2);
            $table->enum('type', ['percentage', 'fixed'])->default('percentage');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->decimal('discount', 10, 2)->default(0)->after('subtotal');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('discount_rules');
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('discount');
        });
    }
};
