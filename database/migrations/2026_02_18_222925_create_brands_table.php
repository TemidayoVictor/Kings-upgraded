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
        Schema::create('brands', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->integer('uuid')->unique();
            $table->string('brand_name')->nullable();
            $table->string('category')->nullable();
            $table->string('sub_category')->nullable();
            $table->string('description')->nullable();
            $table->string('position')->nullable();
            $table->string('state')->nullable();
            $table->string('city')->nullable();
            $table->string('address')->nullable();
            $table->string('about')->nullable();
            $table->string('motto')->nullable();
            $table->string('image')->nullable();
            $table->string('instagram')->nullable();
            $table->string('facebook')->nullable();
            $table->string('twitter')->nullable();
            $table->string('youtube')->nullable();
            $table->string('tiktok')->nullable();
            $table->string('linkedin')->nullable();
            $table->string('website')->nullable();
            $table->string('subscription_status')->nullable();
            $table->string('exp_date')->nullable();
            $table->string('exp_date_parsed')->nullable();
            $table->string('status')->nullable();
            $table->string('mode')->nullable();
            $table->string('brand_type')->nullable();
            $table->string('account_name')->nullable();
            $table->string('account_number')->nullable();
            $table->string('bank_name')->nullable();
            $table->string('revenue')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('brands');
    }
};
