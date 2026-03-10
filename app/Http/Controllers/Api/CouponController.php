<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StoreCouponRequest;
use App\Models\Coupon;
use App\Models\PlatformSetting;
use App\Services\AuditLogService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

use App\Http\Resources\CouponResource;

class CouponController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = Coupon::where('status', 'active')->with('user');

        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'LIKE', "%{$search}%")
                    ->orWhere('description', 'LIKE', "%{$search}%")
                    ->orWhere('place_name', 'LIKE', "%{$search}%");
            });
        }

        if ($request->has('category')) {
            $query->where('place_category', $request->category);
        }

        /* 
        // Proximity search (Haversine)
        if ($request->has(['lat', 'lng'])) {
            $lat = (float) $request->lat;
            $lng = (float) $request->lng;
            $radius = (float) ($request->radius ?? 10);

            // Using raw SQL for Haversine
            $query->select('*')
                ->selectRaw("(6371 * acos(cos(radians(?)) * cos(radians(latitude)) * cos(radians(longitude) - radians(?)) + sin(radians(?)) * sin(radians(latitude)))) AS distance", [$lat, $lng, $lat])
                ->having('distance', '<=', $radius);
        }
        */

        $sort = $request->sort ?? 'newest';
        switch ($sort) {
            case 'cheapest':
                $query->orderBy('coins_price', 'asc');
                break;
            case 'expiring_soon':
                $query->orderBy('expiry_date', 'asc');
                break;
            case 'most_popular':
                $query->orderBy('views_count', 'desc');
                break;
            default:
                $query->orderBy('created_at', 'desc');
        }

        $coupons = $query->paginate($request->per_page ?? 15);

        return response()->json([
            'success' => true,
            'data' => $coupons->items(),
            'pagination' => [
                'current_page' => $coupons->currentPage(),
                'per_page' => $coupons->perPage(),
                'total' => $coupons->total(),
                'last_page' => $coupons->lastPage(),
            ]
        ]);
    }

    public function show($id): JsonResponse
    {
        $coupon = Coupon::findOrFail($id);

        // Increase views (TODO: Batch write via Redis)
        $coupon->increment('views_count');

        // Hide specific data
        unset($coupon->coupon_code);

        return response()->json([
            'success' => true,
            'data' => $coupon,
        ]);
    }

    public function store(StoreCouponRequest $request): JsonResponse
    {
        $imagePath = $request->file('image')->store('coupons', 'public');

        $platformRevenuePercentage = PlatformSetting::where('key', 'platform_revenue_percentage')->first()->value ?? 20;

        $coupon = Coupon::create([
            'user_id' => $request->user()->id,
            'title' => $request->title,
            'description' => $request->description,
            'place_name' => $request->place_name,
            'place_category' => $request->place_category,
            'place_address' => $request->place_address,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'discount_value' => $request->discount_value,
            'discount_type' => $request->discount_type,
            'expiry_date' => $request->expiry_date,
            'coupon_code' => $request->coupon_code, // Will be encrypted via cast
            'image_path' => $imagePath,
            'coins_price' => $request->coins_price,
            'owner_revenue_percentage' => 100 - $platformRevenuePercentage,
            'grace_period_minutes' => PlatformSetting::where('key', 'grace_period_minutes')->first()->value ?? 60,
        ]);

        AuditLogService::log('coupon_created', $coupon);

        return response()->json([
            'success' => true,
            'message' => 'تم نشر الكوبون بنجاح.',
            'data' => $coupon,
        ], 201);
    }
}
