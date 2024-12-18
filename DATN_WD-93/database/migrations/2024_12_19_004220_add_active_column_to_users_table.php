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
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('active')->default(1)->after('email'); // Thêm cột 'active' mặc định là 1, đặt sau cột 'email' // Thêm cột 'active' mặc định là true, đặt sau cột 'email'
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('active'); // Xóa cột 'active' nếu rollback
        });
    }
};
