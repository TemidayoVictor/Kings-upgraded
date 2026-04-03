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
        Schema::create('cart_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cart_id');
            $table->foreignId('product_id')->nullable()->index();
            $table->foreignId('dropshipper_product_id')->nullable()->index();
            $table->string('product_name');
            $table->string('sku')->nullable();
            $table->decimal('unit_price', 10, 2);
            $table->decimal('discount_price', 10, 2)->nullable();
            $table->integer('quantity');
            $table->decimal('subtotal', 10, 2);
            $table->decimal('total', 10, 2);
            $table->json('options')->nullable(); // For size, color, etc.
            $table->json('metadata')->nullable();
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cart_items');
    }
};
