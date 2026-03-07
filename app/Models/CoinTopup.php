<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\CoinTransaction;

class CoinTopup extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'payment_gateway',
        'gateway_transaction_id',
        'amount_paid',
        'coins_awarded',
        'status',
        'gateway_response'
    ];

    protected function casts(): array
    {
        return [
            'amount_paid' => 'decimal:2',
            'gateway_response' => 'json',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function transactions()
    {
        return $this->morphMany(CoinTransaction::class, 'reference');
    }
}
