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
        Schema::table('bills', function (Blueprint $table) {
            $table->decimal('totalPrice', 10, 2)->change();
            $table->decimal('moneyProduct', 10, 2)->change();
            $table->decimal('moneyShip', 10, 2)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bills', function (Blueprint $table) {
            $table->double('totalPrice', 8, 2)->change();
            $table->double('moneyProduct', 8, 2)->change();
            $table->double('moneyShip', 8, 2)->change();
        });
    }
};
