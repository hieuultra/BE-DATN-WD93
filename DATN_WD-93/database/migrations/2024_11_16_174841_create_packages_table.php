<?php

use App\Models\Specialty;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePackagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('packages', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Specialty::class)->constrained();
            $table->string('hospital_name'); // Tên bệnh viện
            $table->text('description'); // Mô tả gói khám
            $table->string('image'); // Ảnh gói khám
            $table->string('address'); // Địa chỉ bệnh viện
            $table->decimal('price', 10, 2); // Giá khám
            $table->timestamps(); // Thời gian tạo và cập nhật
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('packages');
    }
}