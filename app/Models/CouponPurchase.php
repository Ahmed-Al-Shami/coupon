<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CouponPurchase extends Model
{
    use HasFactory;

    protected $fillable = [
        'buyer_id',
        'seller_id',
        'coupon_id',
        'coins_spent',
        'seller_coins_earned',
        'platform_coins_cut',
        'status',
        'revealed_at',
        'grace_period_ends_at',
        'confirmed_at',
        'ip_address',
        'device_fingerprint'
    ];

    protected function casts(): array
    {
        return [
            'revealed_at' => 'datetime',
            'grace_period_ends_at' => 'datetime',
            'confirmed_at' => 'datetime',
        ];
    }

    public function buyer()
    {
        return $this->belongsTo(User::class, 'buyer_id');
    }

    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_id');
    }

    public function coupon()
    {
        return $this->belongsTo(Coupon::class);
    }
}
