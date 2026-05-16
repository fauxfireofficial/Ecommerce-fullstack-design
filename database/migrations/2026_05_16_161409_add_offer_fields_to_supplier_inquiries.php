<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('supplier_inquiries', function (Blueprint $table) {
            $table->decimal('offered_price', 12, 2)->nullable()->after('admin_notes');
            $table->text('admin_message')->nullable()->after('offered_price');
            $table->text('user_reply')->nullable()->after('admin_message');
        });
    }

    public function down(): void
    {
        Schema::table('supplier_inquiries', function (Blueprint $table) {
            $table->dropColumn(['offered_price', 'admin_message', 'user_reply']);
        });
    }
};
