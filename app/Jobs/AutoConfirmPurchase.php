<?php

namespace App\Jobs;

use App\Models\CouponPurchase;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class AutoConfirmPurchase implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $purchase;

    public function __construct(CouponPurchase $purchase)
    {
        $this->purchase = $purchase;
    }

    public function handle(): void
    {
        if ($this->purchase->status === 'revealed' && $this->purchase->revealed_at->addHours(24)->isPast()) {
            $this->purchase->update([
                'status' => 'confirmed',
                'confirmed_at' => now(),
            ]);

            // In a real app, maybe log this as a system-confirmed action
        }
    }
}
