<?php

namespace App\Services;

use App\Models\Coupon;
use App\Models\CouponPurchase;
use App\Models\User;
use App\Models\PlatformSetting;
use Illuminate\Support\Facades\DB;
use App\Services\CoinService;
use App\Services\AuditLogService;

use App\Services\NotificationService;

class CouponService
{
    protected $coinService;

    public function __construct(CoinService $coinService)
    {
        $this->coinService = $coinService;
    }

    public function purchase(User $buyer, Coupon $coupon): CouponPurchase
    {
        return DB::transaction(function () use ($buyer, $coupon) {
            // Lock records
            $buyer = User::lockForUpdate()->findOrFail($buyer->id);
            $coupon = Coupon::lockForUpdate()->findOrFail($coupon->id);
            $seller = User::lockForUpdate()->findOrFail($coupon->user_id);

            // Validation
            if ($coupon->status !== 'active') {
                throw new \Exception("هذا الكوبون غير متاح للشراء.");
            }
            if ($coupon->user_id === $buyer->id) {
                throw new \Exception("لا يمكنك شراء الكوبون الخاص بك.");
            }
            if ($buyer->coins_balance < $coupon->coins_price) {
                throw new \Exception("رصيد الكوينز غير كافٍ.");
            }
            if ($coupon->expiry_date && \Illuminate\Support\Carbon::parse($coupon->expiry_date)->isPast()) {
                throw new \Exception("هذا الكوبون منتهي الصلاحية.");
            }

            $coinsPrice = $coupon->coins_price;
            $platformRevenuePercentage = PlatformSetting::where('key', 'platform_revenue_percentage')->first()->value ?? 20;
            $sellerRevenuePercentage = $coupon->owner_revenue_percentage ?? (100 - $platformRevenuePercentage);

            $sellerCoins = (int) round($coinsPrice * $sellerRevenuePercentage / 100);
            $platformCoins = $coinsPrice - $sellerCoins;

            // Debit buyer
            $this->coinService->debit($buyer, $coinsPrice, 'purchase', $coupon, "شراء كوبون: {$coupon->title}");

            // Credit seller
            $this->coinService->credit($seller, $sellerCoins, 'revenue_share', $coupon, "عائد بيع كوبون: {$coupon->title}");

            // Create purchase record
            $purchase = CouponPurchase::create([
                'buyer_id' => $buyer->id,
                'seller_id' => $seller->id,
                'coupon_id' => $coupon->id,
                'coins_spent' => $coinsPrice,
                'seller_coins_earned' => $sellerCoins,
                'platform_coins_cut' => $platformCoins,
                'status' => 'pending',
                'grace_period_ends_at' => now()->addMinutes($coupon->grace_period_minutes),
                'ip_address' => request()->ip(),
                'device_fingerprint' => request()->header('X-Device-Fingerprint'),
            ]);

            AuditLogService::log('coupon_purchased', $purchase);

            // Notify Seller
            NotificationService::send($seller, 'تم بيع كوبون!', "لقد قام المستخدم {$buyer->name} بشراء كوبونك: {$coupon->title}");

            // Notify Buyer
            NotificationService::send($buyer, 'تم الشراء بنجاح', "لقد اشتريت كوبون {$coupon->title} بنجاح. سيتم تحرير الكود قريباً.");

            // Dispatch Jobs
            \App\Jobs\ProcessCouponReveal::dispatch($purchase)->delay($purchase->grace_period_ends_at);
            \App\Jobs\FlagSuspiciousAccount::dispatch($buyer);

            return $purchase;
        });
    }
}
