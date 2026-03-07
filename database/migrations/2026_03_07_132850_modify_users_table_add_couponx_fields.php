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
        Schema::table('users', function (Blueprint $table) {
            $table->string('phone')->unique()->after('email');
            $table->bigInteger('coins_balance')->default(0)->after('password');
            $table->boolean('is_verified')->default(false)->after('coins_balance');
            $table->boolean('is_banned')->default(false)->after('is_verified');
            $table->string('ban_reason')->nullable()->after('is_banned');
            $table->timestamp('ban_expires_at')->nullable()->after('ban_reason');
            $table->integer('reports_count')->default(0)->after('ban_expires_at');
            $table->boolean('flagged_for_review')->default(false)->after('reports_count');
            $table->timestamp('last_login_at')->nullable()->after('flagged_for_review');
            $table->string('ip_address')->nullable()->after('last_login_at');
            $table->string('device_fingerprint')->nullable()->after('ip_address');
            $table->text('two_factor_secret')->nullable()->after('device_fingerprint');
            $table->timestamp('two_factor_confirmed_at')->nullable()->after('two_factor_secret');
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'phone', 'coins_balance', 'is_verified', 'is_banned', 'ban_reason',
                'ban_expires_at', 'reports_count', 'flagged_for_review', 'last_login_at',
                'ip_address', 'device_fingerprint', 'two_factor_secret', 'two_factor_confirmed_at'
            ]);
            $table->dropSoftDeletes();
        });
    }
};
