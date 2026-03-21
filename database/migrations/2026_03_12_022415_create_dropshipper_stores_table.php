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
        Schema::create('dropshipper_stores', function (Blueprint $table) {
            $table->id();
            $table->foreignId('dropshipper_id');
            $table->foreignId('brand_id');
            $table->string('store_name');
            $table->string('slug')->unique();
            $table->string('image')->nullable();
            $table->json('settings')->nullable(); // Theme settings, layout, etc.
            $table->string('status')->nullable();
            $table->timestamps();

            $table->index(['dropshipper_id', 'brand_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dropshipper_stores');
    }
};
