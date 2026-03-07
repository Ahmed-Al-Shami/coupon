<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('coupon_purchases', function (Blueprint $table) {
            $table->id();
            $table->foreignId('buyer_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('seller_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('coupon_id')->constrained()->onDelete('cascade');
            $table->integer('coins_spent');
            $table->integer('seller_coins_earned');
            $table->integer('platform_coins_cut');
            $table->enum('status', ['pending', 'revealed', 'confirmed', 'disputed', 'refunded'])->default('pending');
            $table->timestamp('revealed_at')->nullable();
            $table->timestamp('grace_period_ends_at');
            $table->timestamp('confirmed_at')->nullable();
            $table->string('ip_address')->nullable();
            $table->string('device_fingerprint')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coupon_purchases');
    }
};
