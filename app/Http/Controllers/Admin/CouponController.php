<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Services\AuditLogService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $coupons = Coupon::query()
            ->when($request->status, function ($q, $s) {
                $q->where('status', $s);
            })
            ->when($request->search, function ($q, $s) {
                $q->where('title', 'LIKE', "%{$s}%");
            })
            ->with('user')
            ->paginate();

        return response()->json(['success' => true, 'data' => $coupons]);
    }

    public function verify(Coupon $coupon): JsonResponse
    {
        $coupon->update(['is_verified' => true]);

        AuditLogService::log('admin_verified_coupon', $coupon);

        return response()->json(['success' => true, 'message' => 'تم توثيق الكوبون بنجاح.']);
    }

    public function updateStatus(Coupon $coupon, Request $request): JsonResponse
    {
        $request->validate(['status' => 'required|in:active,suspended,expired']);

        $coupon->update(['status' => $request->status]);

        AuditLogService::log('admin_updated_coupon_status', $coupon, [], ['status' => $request->status]);

        return response()->json(['success' => true, 'message' => 'تم تحديث حالة الكوبون.']);
    }
}
