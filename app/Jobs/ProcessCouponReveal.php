<?php

namespace App\Jobs;

use App\Models\CouponPurchase;
use App\Services\NotificationService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessCouponReveal implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $purchase;

    public function __construct(CouponPurchase $purchase)
    {
        $this->purchase = $purchase;
    }

    public function handle(): void
    {
        // Sugggest the user can now reveal the coupon.
        NotificationService::send($this->purchase->buyer, 'كوبونك جاهز!', "انتهت فترة السماح. يمكنك الآن الكشف عن الكود الخاص بكوبون: {$this->purchase->coupon->title}");

        \Illuminate\Support\Facades\Log::info("Purchase {$this->purchase->id} is ready for reveal.");
    }
}
