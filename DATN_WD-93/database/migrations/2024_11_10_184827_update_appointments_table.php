<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('appoinments', function (Blueprint $table) {
            $table->text('classify')->nullable(); // Thêm cột 'address' (địa chỉ)
            $table->string('name')->nullable(); // Thêm cột 'name' (tên)
            $table->string('phone')->nullable(); // Thêm cột 'phone' (số điện thoại)
            $table->text('address')->nullable(); // Thêm cột 'address' (địa chỉ)
        });
    }
    
    public function down()
    {
        Schema::table('appoinments', function (Blueprint $table) {
            $table->dropColumn(['classify', 'name', 'phone', 'address']); // Xóa các cột khi rollback
        });
    }    
};