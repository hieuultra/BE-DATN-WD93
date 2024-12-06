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
            $table->double('max_discount')->nullable()->after('value'); // Thêm cột max_discount
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('coupons', function (Blueprint $table) {
            Schema::table('coupons', function (Blueprint $table) {
                $table->dropColumn('max_discount'); // Xóa cột max_discount khi rollback
            });
        });
    }
};
