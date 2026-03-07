<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\CoinTransaction;

class WithdrawalRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'coins_amount',
        'real_money_amount',
        'exchange_rate',
        'payment_method',
        'payment_details',
        'status',
        'admin_note',
        'processed_by',
        'processed_at'
    ];

    protected function casts(): array
    {
        return [
            'real_money_amount' => 'decimal:2',
            'exchange_rate' => 'decimal:4',
            'payment_details' => 'encrypted',
            'processed_at' => 'datetime',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function processedBy()
    {
        return $this->belongsTo(User::class, 'processed_by');
    }

    public function transactions()
    {
        return $this->morphMany(CoinTransaction::class, 'reference');
    }
}
