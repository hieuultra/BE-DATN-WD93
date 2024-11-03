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
        Schema::table('carts', function (Blueprint $table) {
            // Xóa các cột không cần thiết nếu muốn
            $table->dropForeign(['product_id']);
            $table->dropColumn(['namePro', 'imagePro', 'pricePro', 'quantity', 'total','product_id']);
            $table->double('total_price')->default(0)->before('created_at');
            $table->unsignedBigInteger('user_id')->nullable()->after('id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('carts', function (Blueprint $table) {
            // Khôi phục lại các cột đã bị xóa nếu cần
            $table->string('namePro');
            $table->string('imagePro');
            $table->double('pricePro');
            $table->unsignedInteger('quantity')->default(0);
            $table->double('total')->default(0);
            $table->unsignedBigInteger('product_id')->nullable();
            $table->foreign('product_id')->references('id')->on('products')->onDelete('set null');

            // Xóa khóa ngoại
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
        });
    }
};
