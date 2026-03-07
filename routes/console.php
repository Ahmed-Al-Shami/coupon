<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

use Illuminate\Support\Facades\Schedule;
use App\Models\CouponPurchase;
use App\Jobs\AutoConfirmPurchase;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Schedule::call(function () {
    // Auto confirm revealed purchases after 24h
    $purchases = CouponPurchase::where('status', 'revealed')
        ->where('revealed_at', '<=', now()->subHours(24))
        ->get();

    foreach ($purchases as $purchase) {
        AutoConfirmPurchase::dispatch($purchase);
    }
})->hourly();

Schedule::call(function () {
    // Expire old coupons
    \App\Models\Coupon::where('status', 'active')
        ->where('expiry_date', '<', now())
        ->update(['status' => 'expired']);
})->daily();
