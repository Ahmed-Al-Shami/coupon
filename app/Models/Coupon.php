<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Coupon extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'place_name',
        'place_category',
        'place_address',
        'latitude',
        'longitude',
        'discount_value',
        'discount_type',
        'original_price',
        'expiry_date',
        'coupon_code',
        'image_path',
        'coins_price',
        'status',
        'owner_revenue_percentage',
        'views_count',
        'purchases_count',
        'is_verified',
        'reports_count',
        'flagged_for_review',
        'grace_period_minutes'
    ];

    protected function casts(): array
    {
        return [
            'latitude' => 'decimal:8',
            'longitude' => 'decimal:8',
            'discount_value' => 'decimal:2',
            'original_price' => 'decimal:2',
            'expiry_date' => 'date',
            'coupon_code' => 'encrypted',
            'is_verified' => 'boolean',
            'flagged_for_review' => 'boolean',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function purchases()
    {
        return $this->hasMany(CouponPurchase::class);
    }

    public function reports()
    {
        return $this->hasMany(Report::class, 'reported_coupon_id');
    }
}
