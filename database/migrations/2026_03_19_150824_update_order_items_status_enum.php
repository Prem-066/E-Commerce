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
        Schema::table('order_items', function (Blueprint $table) {
            $table->enum('status', ['Ordered', 'Pending', 'Confirmed', 'Processing', 'Out for Delivery', 'Delivered', 'Cancelled', 'Returned', 'Refunded'])->default('Ordered')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('order_items', function (Blueprint $table) {
            $table->enum('status', ['Ordered', 'Cancelled', 'Returned', 'Delivered'])->default('Ordered')->change();
        });
    }

};
