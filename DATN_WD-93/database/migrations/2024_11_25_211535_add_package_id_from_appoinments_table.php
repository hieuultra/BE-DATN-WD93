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
            $table->unsignedBigInteger('package_id')->nullable()->after('id'); // Thêm cột package_id
            $table->foreign('package_id')->references('id')->on('packages')->onDelete('cascade'); // Thiết lập khóa ngoại
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('appoinments', function (Blueprint $table) {
            $table->dropForeign(['package_id']); // Xóa khóa ngoại
            $table->dropColumn('package_id');    // Xóa cột package_id
        });
    }
};
