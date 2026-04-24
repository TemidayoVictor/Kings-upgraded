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
        Schema::create('dropshipper_earnings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('dropshipper_store_id');
            $table->foreignId('order_id');
            $table->integer('amount')->nullable();
            $table->timestamps();

            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dropshipper_earnings');
    }
};
