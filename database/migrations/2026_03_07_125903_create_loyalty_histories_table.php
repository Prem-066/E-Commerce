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
        Schema::create('loyalty_histories', function (Blueprint $table) {
            $table->id();
            $table->uuid('customer_id');
            $table->uuid('order_id');
            $table->integer('points');
            $table->enum('type', ['earned', 'redeemed']);
            $table->text('description')->nullable();
            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
            $table->enum('status', ['pending', 'confirmed', 'cancelled'])->default('pending');
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
            $table->timestamp('created_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loyalty_histories');
    }
};
