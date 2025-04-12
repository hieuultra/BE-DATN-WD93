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
        Schema::table('product_questions', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->nullable(); // Có thể cho khách vãng lai hỏi
            $table->boolean('is_answered')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('product_questions', function (Blueprint $table) {
            $table->dropColumn('user_id');
            $table->dropColumn('is_answered');
        });
    }
};
