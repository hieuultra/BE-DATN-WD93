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
        Schema::create('variant_products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_product')->nullable(); // khóa ngoại với products
            $table->unsignedBigInteger('id_variant')->nullable(); // khóa ngoại với variant_packages
            $table->unsignedInteger('quantity');
            $table->double('price');
            $table->foreign('id_product')->references('id')->on('products')->onDelete('set null');
            $table->foreign('id_variant')->references('id')->on('variant_packages')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('variant_products');
    }
};
