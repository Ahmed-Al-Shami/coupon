<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Coupon;
use App\Models\CouponPurchase;
use App\Models\WithdrawalRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function stats(): JsonResponse
    {
        $stats = [
            'total_users' => User::count(),
            'total_coupons' => Coupon::count(),
            'active_coupons' => Coupon::where('status', 'active')->count(),
            'total_purchases' => CouponPurchase::count(),
            'total_sales_value' => CouponPurchase::sum('coins_spent'),
            'platform_revenue' => CouponPurchase::sum('platform_coins_cut'),
            'pending_withdrawals' => WithdrawalRequest::where('status', 'pending')->count(),
            'pending_reports' => \App\Models\Report::where('status', 'pending')->count(),
            'new_users_today' => User::whereDate('created_at', today())->count(),
        ];

        // Last 7 days sales
        $salesHistory = CouponPurchase::select(DB::raw('DATE(created_at) as date'), DB::raw('SUM(coins_spent) as total'))
            ->where('created_at', '>=', now()->subDays(7))
            ->groupBy('date')
            ->get();

        return response()->json([
            'success' => true,
            'data' => [
                'stats' => $stats,
                'sales_history' => $salesHistory
            ]
        ]);
    }
}
