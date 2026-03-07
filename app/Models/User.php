<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'coins_balance',
        'is_verified',
        'is_banned',
        'ban_reason',
        'ban_expires_at',
        'reports_count',
        'flagged_for_review',
        'last_login_at',
        'ip_address',
        'device_fingerprint',
        'two_factor_confirmed_at',
        'is_admin',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_secret',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_verified' => 'boolean',
            'is_banned' => 'boolean',
            'flagged_for_review' => 'boolean',
            'ban_expires_at' => 'datetime',
            'last_login_at' => 'datetime',
            'two_factor_confirmed_at' => 'datetime',
            'two_factor_secret' => 'encrypted',
            'is_admin' => 'boolean',
        ];
    }

    public function coupons()
    {
        return $this->hasMany(Coupon::class);
    }

    public function purchases()
    {
        return $this->hasMany(CouponPurchase::class, 'buyer_id');
    }

    public function sales()
    {
        return $this->hasMany(CouponPurchase::class, 'seller_id');
    }

    public function transactions()
    {
        return $this->hasMany(CoinTransaction::class);
    }

    public function topups()
    {
        return $this->hasMany(CoinTopup::class);
    }

    public function withdrawalRequests()
    {
        return $this->hasMany(WithdrawalRequest::class);
    }

    public function reports()
    {
        return $this->hasMany(Report::class, 'reporter_id');
    }
}
