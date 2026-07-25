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
        Schema::table('dropshippers', function (Blueprint $table) {
            $table->string('subscription_type')->after('image')->nullable();
            $table->date('last_subscription_type_update')->after('subscription_type')->nullable();
            $table->date('exp_date')->after('last_subscription_type_update')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('dropshippers', function (Blueprint $table) {
            $table->dropColumn('subscription_type');
            $table->dropColumn('last_subscription_type_update');
            $table->dropColumn('exp_date');
        });
    }
};
