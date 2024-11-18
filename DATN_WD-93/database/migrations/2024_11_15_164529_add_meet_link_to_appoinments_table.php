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
        Schema::table('appoinments', function (Blueprint $table) {
            $table->string('meet_link')->nullable(); // Thêm cột 'meet_link' để lưu link Google Meet
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('appoinments', function (Blueprint $table) {
            $table->dropColumn('meet_link'); // Xóa cột khi rollback
        });
    }
};
