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
        Schema::table('order_items', function (Blueprint $table) {
            $table->boolean('is_gift')->default(false)->after('total');
            $table->text('gift_message')->nullable()->after('is_gift');
            $table->string('wrapping_color')->nullable()->after('gift_message');
            $table->foreignId('gift_box_id')->nullable()->after('wrapping_color')->constrained('gift_boxes')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('order_items', function (Blueprint $table) {
            $table->dropForeign(['gift_box_id']);
            $table->dropColumn(['is_gift', 'gift_message', 'wrapping_color', 'gift_box_id']);
        });
    }
};
