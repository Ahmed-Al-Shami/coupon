<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CouponController;
use App\Http\Controllers\Api\PurchaseController;
use App\Http\Controllers\Api\WithdrawalController;
use App\Http\Controllers\Api\CoinsController;
use App\Http\Controllers\Api\ReportController;
use App\Http\Controllers\Api\NotificationController;

Route::prefix('v1')->group(function () {
    // Auth Routes
    Route::prefix('auth')->group(function () {
        Route::post('/register', [AuthController::class, 'register'])
            ->middleware(['guest', 'throttle:5,60']); // 5 tries per hour? Actually throttle:5,60 is 5 per min.
        // Laravel default is throttle:requests,minutes. 
        // 5/hour would be throttle:5,60 (where 60 is minutes).

        Route::post('/login', [AuthController::class, 'login'])
            ->middleware(['guest', 'throttle:10,15']); // 10 tries per 15 mins

        Route::middleware(['auth:sanctum', 'check.banned', 'fingerprint'])->group(function () {
            Route::post('/logout', [AuthController::class, 'logout']);
            Route::post('/logout-all', [AuthController::class, 'logoutAll']);
            Route::get('/user', function (Request $request) {
                return response()->json([
                    'success' => true,
                    'data' => $request->user(),
                ]);
            });

            // Coupon Routes
            Route::post('/coupons', [CouponController::class, 'store']);
            Route::post('/coupons/{id}/purchase', [PurchaseController::class, 'purchase']);
            Route::get('/purchases/{id}/reveal', [PurchaseController::class, 'reveal']);
            Route::post('/purchases/{id}/confirm', [PurchaseController::class, 'confirm']);
            Route::post('/purchases/{id}/dispute', [PurchaseController::class, 'dispute']);

            // Coins Routes
            Route::get('/coins/balance', [CoinsController::class, 'balance']);
            Route::get('/coins/transactions', [CoinsController::class, 'transactions']);
            Route::post('/coins/topup', [CoinsController::class, 'topup']);

            // Withdrawal Routes
            Route::get('/withdrawals', [WithdrawalController::class, 'index']);
            Route::post('/withdrawals/request', [WithdrawalController::class, 'store']);

            // Report Routes
            Route::post('/reports', [ReportController::class, 'store']);

            // Notifications
            Route::get('/notifications', [NotificationController::class, 'index']);
            Route::post('/notifications/{id}/read', [NotificationController::class, 'markAsRead']);
            Route::post('/notifications/read-all', [NotificationController::class, 'markAllAsRead']);
        });
    });

    // Public Routes
    Route::get('/coupons', [CouponController::class, 'index']);
    Route::get('/coupons/{id}', [CouponController::class, 'show']);
    Route::get('/coins/packages', [CoinsController::class, 'packages']);
    // Admin Routes
    Route::prefix('admin')->middleware(['auth:sanctum', 'check.banned', 'admin'])->group(function () {
        Route::get('/stats', [\App\Http\Controllers\Admin\DashboardController::class, 'stats']);

        // User Moderation
        Route::get('/users', [\App\Http\Controllers\Admin\UserController::class, 'index']);
        Route::post('/users/{user}/ban', [\App\Http\Controllers\Admin\UserController::class, 'ban']);
        Route::post('/users/{user}/unban', [\App\Http\Controllers\Admin\UserController::class, 'unban']);
        Route::post('/users/{user}/adjust-coins', [\App\Http\Controllers\Admin\UserController::class, 'adjustCoins']);

        // Coupon Moderation
        Route::get('/coupons', [\App\Http\Controllers\Admin\CouponController::class, 'index']);
        Route::post('/coupons/{coupon}/verify', [\App\Http\Controllers\Admin\CouponController::class, 'verify']);
        Route::post('/coupons/{coupon}/status', [\App\Http\Controllers\Admin\CouponController::class, 'updateStatus']);

        // Withdrawal Management
        Route::get('/withdrawals', [\App\Http\Controllers\Admin\WithdrawalController::class, 'index']);
        Route::post('/withdrawals/{withdrawal}/process', [\App\Http\Controllers\Admin\WithdrawalController::class, 'process']);

        // Report Management
        Route::get('/reports', [\App\Http\Controllers\Admin\ReportController::class, 'index']);
        Route::post('/reports/{report}/resolve', [\App\Http\Controllers\Admin\ReportController::class, 'resolve']);

        // Platform Economics
        Route::get('/settings', [\App\Http\Controllers\Admin\PlatformSettingController::class, 'index']);
        Route::post('/settings', [\App\Http\Controllers\Admin\PlatformSettingController::class, 'update']);

        Route::apiResource('/packages', \App\Http\Controllers\Admin\PackageController::class);

        Route::get('/audit-logs', [\App\Http\Controllers\Admin\AuditLogController::class, 'index']);
    });
});
