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
        Schema::create('loyalty_settings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->boolean('enable_loyalty')->default(false);
            $table->integer('points_per_hundred')->default(10);
            $table->decimal('point_value_in_currency', 8, 2)->default(1.00);
            $table->integer('min_redeem_points')->default(500);
            $table->integer('referrer_reward_points')->default(100);
            $table->integer('referee_reward_points')->default(50);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loyalty_settings');
    }
};
