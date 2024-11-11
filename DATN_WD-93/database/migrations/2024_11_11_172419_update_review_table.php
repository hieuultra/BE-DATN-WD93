<?php

use App\Models\Appoinment;
use App\Models\Product;
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
        Schema::table('reviews', function (Blueprint $table) {
            // Thêm cột appoinment_id với khóa ngoại, cho phép NULL
            $table->foreignIdFor(Appoinment::class)->nullable()->constrained()->onDelete('set null');

            // Thêm cột product_id với khóa ngoại, cho phép NULL
            $table->unsignedBigInteger('product_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reviews', function (Blueprint $table) {
            // Xóa khoá ngoại nếu cần
            $table->dropForeign(['appoinment_id']);
            $table->unsignedBigInteger('product_id')->nullable(false)->change();
        });
    }
};
