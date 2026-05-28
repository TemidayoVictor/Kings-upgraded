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
        Schema::create('brand_settings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('brand_id');
            $table->string('hero_tagline')->nullable(); // e.g., "curated lifestyle collections"
            $table->string('hero_title_line_1')->nullable(); // e.g., "Elixirs for the"
            $table->string('hero_title_line_2_italic')->nullable(); // e.g., "modern identity."
            $table->text('hero_description')->nullable();
            $table->string('hero_button_text')->nullable(); // e.g., "Discover Bestsellers"
            $table->string('primary_color', 7)->default('#000000'); // Hex Color Accent
            $table->string('secondary_color', 7)->default('#f7f6f2'); // Hex Color Surface Background
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('brand_settings');
    }
};
