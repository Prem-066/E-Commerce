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
            $table->uuid('id')->primary();
            $table->foreignUuid('customer_id')->constrained('customers')->onDelete('cascade');
            $table->string('order_number')->unique();
            $table->string('customer_last_name')->nullable();
            $table->string('customer_email')->nullable();
            $table->text('address')->nullable();
            $table->string('city')->nullable();
            $table->string('zip_code')->nullable();
            $table->string('shipping_charges')->nullable();
            $table->string('order_notes')->nullable();
            $table->foreignId('admin_id')->constrained('users');
            $table->foreignId('store_id')->nullable()->constrained('stores');
            $table->foreignId('employee_id')->nullable()->constrained('users');
            $table->foreignId('user_id')->nullable()->constrained('users');
            $table->string('total_amount');
            $table->string('order_status')->default('pending');
            $table->string('customer_phone')->nullable();
            $table->string('customer_name')->nullable();
            $table->enum('order_type', ['offline', 'online'])->default('offline');
            $table->enum('payment_status', ['pending', 'paid', 'failed', 'Unpaid', 'Refunded'])->default('pending');
            $table->string('payment_method');
            $table->string('payment_id')->nullable();
            $table->timestamps();
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
