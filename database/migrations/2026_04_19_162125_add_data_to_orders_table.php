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
        Schema::table('orders', function (Blueprint $table) {
            $table->string('dropshipper_status')->nullable()->after('cancelled_at');
            $table->foreignId('order_batch_id')->nullable()->after('dropshipper_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('dropshipper_status');
            $table->dropColumn('order_batch_id');
        });
    }
};
