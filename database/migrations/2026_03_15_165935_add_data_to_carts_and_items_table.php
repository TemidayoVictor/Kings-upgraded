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
        Schema::table('carts', function (Blueprint $table) {
            $table->foreignId('dropshipper_store_id')
                ->nullable()
                ->after('brand_id');

            // Add index for performance
            $table->index(['dropshipper_store_id', 'user_id']);
            $table->index(['dropshipper_store_id', 'session_id']);
        });

        // Update cart_items table
        Schema::table('cart_items', function (Blueprint $table) {
            $table->foreignId('dropshipper_product_id')
                ->nullable()
                ->after('product_id');

            $table->decimal('dropship_price', 10, 2)
                ->nullable()
                ->after('discount_price');

            $table->decimal('custom_price', 10, 2)
                ->nullable()
                ->after('dropship_price');

            // Add index
            $table->index('dropshipper_product_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cart_items', function (Blueprint $table) {
            $table->dropColumn(['dropshipper_product_id', 'dropship_price', 'custom_price']);
        });

        Schema::table('carts', function (Blueprint $table) {
            $table->dropColumn('dropshipper_store_id');
        });
    }
};
