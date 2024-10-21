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
        Schema::table('image_products', function (Blueprint $table) {
            $table->dropForeign(['product_id']); // Xóa ràng buộc khóa ngoại hiện tại
            $table->foreign('product_id') // Tạo lại khóa ngoại với cascade delete
                ->references('id')->on('products')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('image_products', function (Blueprint $table) {
            $table->dropForeign(['product_id']); // Xóa ràng buộc khóa ngoại
            $table->foreign('product_id') // Tạo lại ràng buộc khóa ngoại không có cascade delete
                ->references('id')->on('products');
        });
    }
};
