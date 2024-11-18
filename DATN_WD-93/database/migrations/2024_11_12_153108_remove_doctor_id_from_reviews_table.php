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
        Schema::table('reviews', function (Blueprint $table) {
            $table->dropForeign(['doctor_id']); // Xóa ràng buộc khóa ngoại trước
            $table->dropColumn('doctor_id'); // Xóa cột doctor_id
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reviews', function (Blueprint $table) {
            $table->foreignId('doctor_id')->constrained(); // Thêm lại cột doctor_id và ràng buộc khóa ngoại
        });
    }
};
