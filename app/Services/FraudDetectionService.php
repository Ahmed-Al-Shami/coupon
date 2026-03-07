<?php

namespace App\Services;

use App\Models\User;
use App\Models\CouponPurchase;
use App\Models\PlatformSetting;
use Illuminate\Support\Facades\Notification;

class FraudDetectionService
{

    public function checkUserReports(User $user): void
    {
        $reportsThreshold = PlatformSetting::where('key', 'reports_suspension_threshold')->first()->value ?? 5;

        if ($user->reports_count >= $reportsThreshold) {
            $user->update([
                'flagged_for_review' => true,
                'is_banned' => true,
                'ban_reason' => 'تم تعليق الحساب تلقائياً بسبب كثرة البلاغات للمراجعة الإدارية.'
            ]);

            // Suspend coupons
            $user->coupons()->where('status', 'active')->update(['status' => 'suspended']);

            // Suspend withdrawals
            $user->withdrawalRequests()->where('status', 'pending')
                ->update(['status' => 'processing', 'admin_note' => 'معلق للمراجعة بسبب بلاغات على الحساب.']);

            // In a real app, notify admins here
        }
    }

    public function detectPurchaseFraud(CouponPurchase $purchase): array
    {
        $flags = [];

        // Same IP?
        if ($purchase->ip_address && $purchase->ip_address === $purchase->coupon->user->ip_address) {
            $flags[] = 'same_ip_buyer_seller';
        }

        // Same Fingerprint?
        if ($purchase->device_fingerprint && $purchase->device_fingerprint === $purchase->coupon->user->device_fingerprint) {
            $flags[] = 'same_device_buyer_seller';
        }

        // Excessive purchases?
        $recentPurchases = CouponPurchase::where('buyer_id', $purchase->buyer_id)
            ->where('created_at', '>=', now()->subHour())
            ->count();
        if ($recentPurchases > 10) {
            $flags[] = 'excessive_purchases';
        }

        return $flags;
    }

    public function checkReporterAbuse(User $user): void
    {
        if ($user->reports_sent_count >= 5) { // Fixed threshold as per user request
            $user->update([
                'flagged_for_review' => true,
            ]);

            \App\Services\AuditLogService::log('reporter_flagged_for_review', $user, [], [
                'reason' => 'User has sent more than 5 reports. Reviewing for malicious reporting or fraud.'
            ]);
        }
    }
}
