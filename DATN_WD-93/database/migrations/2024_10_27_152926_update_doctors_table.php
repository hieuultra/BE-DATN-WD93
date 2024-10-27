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
        Schema::table('doctors', function (Blueprint $table) {
            $table->string('title')->nullable()->after('specialty_id'); // Học hàm, học vị
            $table->integer('experience_years')->nullable()->after('title'); // Số năm kinh nghiệm
            $table->string('position')->nullable()->after('experience_years'); // Vị trí công tác
            $table->string('workplace')->nullable()->after('position'); // Nơi công tác
            $table->integer('min_age')->nullable()->after('workplace'); // Độ tuổi tối thiểu nhận khám
            $table->double('examination_fee')->nullable()->after('min_age');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('doctors', function (Blueprint $table) {
            $table->dropColumn([
                'title',
                'experience_years',
                'position',
                'workplace',
                'min_age',
                'examination_fee'
            ]);
        });
    }
};
