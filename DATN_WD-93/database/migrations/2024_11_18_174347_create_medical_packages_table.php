<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMedicalPackagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('medical_packages', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('package_id');
            $table->enum('category', ['khám lâm sàng', 'xét nghiệm', 'chuẩn đoán thăm dò chức năng', 'tư vấn kết quả']);
            $table->string('name');
            $table->text('description')->nullable();
            $table->timestamps();

            // Foreign key constraint
            $table->foreign('package_id')->references('id')->on('packages')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('medical_packages');
    }
}