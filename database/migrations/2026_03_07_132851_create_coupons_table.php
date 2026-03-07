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
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->text('description');
            $table->string('place_name');
            $table->string('place_category');
            $table->string('place_address');
            $table->decimal('latitude', 10, 8);
            $table->decimal('longitude', 11, 8);
            $table->decimal('discount_value', 10, 2);
            $table->enum('discount_type', ['percentage', 'fixed']);
            $table->decimal('original_price', 10, 2)->nullable();
            $table->date('expiry_date');
            $table->text('coupon_code'); // Will be encrypted
            $table->string('image_path')->nullable();
            $table->integer('coins_price');
            $table->enum('status', ['active', 'paused', 'sold', 'expired', 'suspended'])->default('active');
            $table->integer('owner_revenue_percentage');
            $table->integer('views_count')->default(0);
            $table->integer('purchases_count')->default(0);
            $table->boolean('is_verified')->default(false);
            $table->integer('reports_count')->default(0);
            $table->boolean('flagged_for_review')->default(false);
            $table->integer('grace_period_minutes')->default(60);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coupons');
    }
};
