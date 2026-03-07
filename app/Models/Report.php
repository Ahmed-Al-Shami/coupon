<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory; // Added
use App\Models\User; // Added
use App\Models\Coupon; // Added
use App\Models\CouponPurchase; // Added

class Report extends Model
{
    use HasFactory; // Added

    protected $fillable = [
        'reporter_id',
        'reported_user_id',
        'reported_coupon_id',
        'reported_purchase_id',
        'type',
        'description',
        'evidence_images',
        'status',
        'admin_note',
        'resolved_by',
        'resolved_at'
    ];

    protected function casts(): array
    {
        return [
            'evidence_images' => 'json',
            'resolved_at' => 'datetime',
        ];
    }

    public function reporter()
    {
        return $this->belongsTo(User::class, 'reporter_id');
    }

    public function reportedUser()
    {
        return $this->belongsTo(User::class, 'reported_user_id');
    }

    public function reportedCoupon()
    {
        return $this->belongsTo(Coupon::class, 'reported_coupon_id');
    }

    public function reportedPurchase()
    {
        return $this->belongsTo(CouponPurchase::class, 'reported_purchase_id');
    }

    public function resolver()
    {
        return $this->belongsTo(User::class, 'resolved_by');
    }
}
