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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number')->unique();
            $table->foreignId('user_id')->nullable();
            $table->foreignId('brand_id')->nullable();
            $table->foreignId('dropshipper_id')->nullable();
            $table->foreignId('dropshipper_store_id')->nullable();
            $table->foreignId('delivery_location_id')->nullable();

            // Customer Information
            $table->string('customer_name');
            $table->string('customer_email');
            $table->string('customer_phone');

            // Delivery Information
            $table->string('delivery_address');
            $table->string('delivery_city');
            $table->string('delivery_state');
            $table->string('delivery_zip')->nullable();
            $table->text('delivery_instructions')->nullable();

            // Pricing
            $table->decimal('subtotal', 10, 2);
            $table->decimal('tax', 10, 2)->default(0);
            $table->decimal('shipping', 10, 2)->default(0);
            $table->decimal('discount', 10, 2)->default(0);
            $table->decimal('total', 10, 2);

            // Payment
            $table->string('payment_method')->nullable();
            $table->string('payment_status')->default('pending'); // pending, paid, failed, refunded
            $table->string('payment_reference')->nullable();
            $table->json('payment_data')->nullable();

            // Order Status
            $table->string('status')->default('pending'); // pending, processing, completed, cancelled, refunded
            $table->text('admin_notes')->nullable();
            $table->text('customer_notes')->nullable();

            // Coupon
            $table->string('coupon_code')->nullable();
            $table->json('coupon_data')->nullable();

            // Timestamps
            $table->timestamp('paid_at')->nullable();
            $table->timestamp('shipped_at')->nullable();
            $table->timestamp('delivered_at')->nullable();
            $table->timestamp('cancelled_at')->nullable();
            $table->timestamps();

            // Indexes
            $table->index('order_number');
            $table->index('status');
            $table->index('payment_status');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
