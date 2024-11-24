<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPackageIdToReviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('reviews', function (Blueprint $table) {
            $table->unsignedBigInteger('package_id')->nullable()->after('id'); // Thêm cột package_id
            $table->foreign('package_id')->references('id')->on('packages')->onDelete('cascade'); // Thiết lập khóa ngoại
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
            $table->dropForeign(['package_id']); // Xóa khóa ngoại
            $table->dropColumn('package_id');    // Xóa cột package_id
        });
    }
}

