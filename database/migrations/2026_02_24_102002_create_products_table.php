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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('brand_id');
            $table->string('name');
            $table->text('description');
            $table->string('link')->nullable();
            $table->integer('price');
            $table->integer('sales_price')->nullable();
            $table->integer('dropship_price')->nullable();
            $table->string('date');
            $table->foreignId('section_id')->nullable();
            $table->integer('stock')->nullable();
            $table->boolean('sale_status')->nullable();
            $table->boolean('publish')->nullable();
            $table->boolean('visible');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
