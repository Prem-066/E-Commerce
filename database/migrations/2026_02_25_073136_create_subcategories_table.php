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
        Schema::create('subcategories', function (Blueprint $table) {
             // UUID Primary Key
            $table->uuid('id')->primary();

            // Integer Foreign Keys
            $table->unsignedBigInteger('store_id');
            $table->uuid('category_id'); // Because categories.id is UUID
            $table->unsignedBigInteger('created_by');

            $table->string('name');
            $table->string('slug')->nullable();
            $table->text('description')->nullable();

            $table->boolean('is_active')->default(true);

            $table->timestamps();

            // Foreign Keys
            $table->foreign('store_id')
                  ->references('id')
                  ->on('stores')
                  ->cascadeOnDelete();

            $table->foreign('category_id')
                  ->references('id')
                  ->on('categories')
                  ->cascadeOnDelete();

            $table->foreign('created_by')
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
        Schema::dropIfExists('subcategories');
    }
};
