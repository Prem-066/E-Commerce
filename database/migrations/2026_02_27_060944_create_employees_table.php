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
        Schema::create('employees', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->unsignedBigInteger('user_id')->unique();
            $table->unsignedBigInteger('store_id');
            $table->unsignedBigInteger('admin_id');
            $table->string('phone')->nullable();
            $table->string('address')->nullable();
            $table->string('designation')->nullable();
            $table->string('salary')->nullable();
            $table->date('joining_date')->nullable();
            $table->string('employment_type')->nullable();
            $table->boolean('status')->default(true);
            $table->timestamps();
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->cascadeOnDelete();
            $table->foreign('store_id')
                ->references('id')
                ->on('stores')
                ->cascadeOnDelete();
            $table->foreign('admin_id')
                ->references('id')
                ->on('users')
                ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
