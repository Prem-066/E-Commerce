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
        Schema::create('brands', function (Blueprint $table) {
            $table->uuid('id')->primary();

        // Integer Foreign Keys
        $table->unsignedBigInteger('store_id');
        $table->unsignedBigInteger('created_by');

        $table->string('name');
        $table->string('slug')->nullable();
        $table->text('description')->nullable();
        $table->string('logo')->nullable();

        $table->boolean('is_active')->default(true);

        $table->timestamps();

        // Foreign Keys
        $table->foreign('store_id')
            ->references('id')
            ->on('stores')
            ->cascadeOnDelete();

        $table->foreign('created_by')
            ->references('id')
            ->on('users')
            ->cascadeOnDelete();

        // Unique Brand per Store
        $table->unique(['store_id', 'name']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('brands');
    }
};
