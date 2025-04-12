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
            $table->text('answer')->nullable()->after('question');
            $table->timestamp('answered_at')->nullable()->after('answer');
            $table->unsignedBigInteger('answered_by')->nullable()->after('answered_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('product_questions', function (Blueprint $table) {
            $table->dropColumn('answer');
            $table->dropColumn('answered_at');
            $table->dropColumn('answered_by');
        });
    }
};
