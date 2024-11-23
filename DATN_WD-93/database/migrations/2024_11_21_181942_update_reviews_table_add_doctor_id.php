<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateReviewsTableAddDoctorId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('reviews', function (Blueprint $table) {
            $table->unsignedBigInteger('doctor_id')->nullable()->after('id'); // Thêm cột doctor_id
            $table->foreign('doctor_id')->references('id')->on('doctors')->onDelete('set null'); // Khóa ngoại
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('reviews', function (Blueprint $table) {
            $table->dropForeign(['doctor_id']); // Xóa khóa ngoại
            $table->dropColumn('doctor_id'); // Xóa cột
        });
    }
}