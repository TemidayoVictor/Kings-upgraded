<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sale_tags', function (Blueprint $table) {
            $table->id();

            $table->foreignId('sale_id');

            $table->string('name', 50);

            $table->string('normalized_name', 50);

            $table->timestamps();

            $table->unique(
                ['sale_id', 'normalized_name'],
                'sale_tags_sale_normalized_unique'
            );

            $table->index('normalized_name');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sale_tags');
    }
};
