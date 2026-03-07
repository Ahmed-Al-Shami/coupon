<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Models\CouponPurchase;
use App\Services\CouponService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

use App\Http\Resources\PurchaseResource;

class PurchaseController extends Controller
{
    protected $couponService;

    public function __construct(CouponService $couponService)
    {
        $this->couponService = $couponService;
    }

    public function purchase($id, Request $request): JsonResponse
    {
        try {
            $coupon = Coupon::findOrFail($id);
            $purchase = $this->couponService->purchase($request->user(), $coupon);

            return response()->json([
                'success' => true,
                'message' => 'تم شراء الكوبون بنجاح.',
                'data' => new PurchaseResource($purchase->load(['buyer', 'seller', 'coupon']))
            ]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 400);
        }
    }

    public function reveal($id, Request $request): JsonResponse
    {
        $purchase = CouponPurchase::where('buyer_id', $request->user()->id)->findOrFail($id);

        if (now()->lt($purchase->grace_period_ends_at)) {
            return response()->json([
                'success' => false,
                'message' => 'فترة السماح لم تنتهِ بعد.',
                'grace_period_ends_at' => $purchase->grace_period_ends_at
            ], 403);
        }

        if ($purchase->status === 'pending') {
            $purchase->update([
                'status' => 'revealed',
                'revealed_at' => now()
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'تم الكشف عن الكوبون.',
            'data' => [
                'coupon_code' => $purchase->coupon->coupon_code,
                'purchase' => new PurchaseResource($purchase->load('coupon'))
            ]
        ]);
    }

    public function confirm($id, Request $request): JsonResponse
    {
        $purchase = CouponPurchase::findOrFail($id);

        if ($purchase->buyer_id !== $request->user()->id) {
            return response()->json(['success' => false, 'message' => 'غير مصرح لك.'], 403);
        }

        if ($purchase->status !== 'revealed') {
            return response()->json(['success' => false, 'message' => 'يجب كشف الكوبون أولاً.'], 400);
        }

        $purchase->update([
            'status' => 'confirmed',
            'confirmed_at' => now(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'تم تأكيد الكوبون بنجاح.',
        ]);
    }

    public function dispute($id, Request $request): JsonResponse
    {
        $purchase = CouponPurchase::findOrFail($id);

        if ($purchase->buyer_id !== $request->user()->id) {
            return response()->json(['success' => false, 'message' => 'غير مصرح لك.'], 403);
        }

        $purchase->update(['status' => 'disputed']);

        return response()->json([
            'success' => true,
            'message' => 'تم فتح نزاع. ستقوم الإدارة بالمراجعة.',
        ]);
    }
}
