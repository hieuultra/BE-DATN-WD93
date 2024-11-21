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
        Schema::table('coupons', function (Blueprint $table) {
            $table->unsignedInteger('usage_limit')->nullable()->after('is_active'); // Giới hạn số lần sử dụng
            $table->unsignedInteger('used_count')->default(0)->after('usage_limit'); // Số lần đã sử dụng
            $table->double('min_order_value')->nullable()->after('used_count'); // Giá trị đơn hàng tối thiểu
            $table->text('description')->nullable()->after('min_order_value'); // Mô tả mã giảm giá
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('coupons', function (Blueprint $table) {
            $table->dropColumn('usage_limit');
            $table->dropColumn('used_count');
            $table->dropColumn('min_order_value');
            $table->dropColumn('description');
        });
    }
};