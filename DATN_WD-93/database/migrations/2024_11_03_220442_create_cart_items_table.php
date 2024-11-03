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
        Schema::create('cart_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('cart_id');
            $table->unsignedBigInteger('product_id')->nullable();
            $table->unsignedBigInteger('variant_id')->nullable(); // Biến thể của sản phẩm nếu có
            $table->string('name');
            $table->string('image')->nullable();
            $table->double('price', 8, 2); // Độ dài 8 với 2 chữ số thập phân
            $table->unsignedInteger('quantity')->default(1);
            $table->double('total')->default(0); // Tổng cộng cho sản phẩm
            $table->timestamps();

            // Khóa ngoại
            $table->foreign('cart_id')->references('id')->on('carts')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('set null');
            $table->foreign('variant_id')->references('id')->on('variant_products')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cart_items');
    }
};
