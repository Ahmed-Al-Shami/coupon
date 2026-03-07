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
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('reporter_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('reported_user_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->foreignId('reported_coupon_id')->nullable()->constrained('coupons')->onDelete('cascade');
            $table->foreignId('reported_purchase_id')->nullable()->constrained('coupon_purchases')->onDelete('cascade');
            $table->enum('type', ['fake_coupon', 'fraud', 'spam', 'expired_coupon', 'wrong_info', 'other']);
            $table->text('description');
            $table->json('evidence_images')->nullable();
            $table->enum('status', ['pending', 'investigating', 'resolved', 'dismissed'])->default('pending');
            $table->text('admin_note')->nullable();
            $table->foreignId('resolved_by')->nullable()->constrained('users');
            $table->timestamp('resolved_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};
