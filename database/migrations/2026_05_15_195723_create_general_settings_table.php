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
        Schema::create('general_settings', function (Blueprint $table) {
            $table->id();
            $table->integer('basic_fee')->nullable();
            $table->integer('basic_products_number')->nullable();
            $table->integer('basic_images_number')->nullable();
            $table->integer('basic_additional_products_fee')->nullable();
            $table->integer('basic_additional_products_number')->nullable();
            $table->integer('premium_fee')->nullable();
            $table->integer('premium_products_number')->nullable();
            $table->integer('premium_images_number')->nullable();
            $table->integer('premium_additional_products_fee')->nullable();
            $table->integer('premium_additional_products_number')->nullable();
            $table->integer('platinum_fee')->nullable();
            $table->integer('platinum_products_number')->nullable();
            $table->integer('platinum_images_number')->nullable();
            $table->integer('platinum_additional_products_fee')->nullable();
            $table->integer('platinum_additional_products_number')->nullable();
            $table->integer('dropshipper_fee')->nullable();
            $table->integer('dropshipper_percent')->nullable();
            $table->integer('collector_percent')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('general_settings');
    }
};
