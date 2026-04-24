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
        Schema::table('dropshipper_products', function (Blueprint $table) {
            $table->integer('profit')->default(0)->after('custom_price');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('dropshipper_products', function (Blueprint $table) {
            $table->dropColumn('profit');
        });
    }
};
