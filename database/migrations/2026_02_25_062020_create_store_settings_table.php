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
        Schema::create('store_settings', function (Blueprint $table) {
           $table->id();

        $table->foreignId('store_id')
              ->unique()
              ->constrained()
              ->onDelete('cascade');
        // Store Basic Info
        $table->string('store_email')->nullable();
        $table->string('store_phone')->nullable();
        $table->string('store_address')->nullable();
        $table->string('gst_number')->nullable();
        $table->string('logo')->nullable();
        // SMTP
        $table->string('smtp_host')->nullable();
        $table->string('smtp_port')->nullable();
        $table->string('smtp_username')->nullable();
        $table->string('smtp_password')->nullable();
        $table->string('smtp_encryption')->nullable();
        $table->string('mail_from_address')->nullable();
        $table->string('mail_from_name')->nullable();
        // Toggles
        $table->boolean('email_enabled')->default(false);
        $table->boolean('notification_enabled')->default(false);
        // Invoice
        $table->string('invoice_prefix')->nullable();
        $table->string('currency')->default('INR');

        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('store_settings');
    }
};
