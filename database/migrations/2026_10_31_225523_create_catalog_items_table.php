<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('catalog_items', function (Blueprint $table) {
            $table->id();

            $table->foreignId('brand_id');
            $table->string('image_path');
            $table->string('original_name')->nullable();
            $table->integer('price')->nullable();
            $table->unsignedInteger('sort_order')->default(0);

            $table->timestamps();

            $table->index(['brand_id', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('catalog_items');
    }
};
