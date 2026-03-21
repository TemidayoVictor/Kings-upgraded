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
        Schema::create('dropshipper_products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('dropshipper_store_id');
            $table->foreignId('original_product_id');
            $table->decimal('custom_price', 10, 2)->nullable(); // Dropshipper can override price
            $table->integer('stock_override')->nullable(); // Custom stock management
            $table->json('custom_settings')->nullable(); // Custom SEO, images, etc.
            $table->timestamps();

            $table->unique(['dropshipper_store_id', 'original_product_id'], 'store_product_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dropshipper_products');
    }
};
