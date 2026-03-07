<?php

namespace App\Services;

use App\Models\CoinTransaction;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Exceptions\InsufficientCoinsException;

class CoinService
{
    /**
     * Credit coins to a user.
     */
    public function credit(User $user, int $amount, string $source, Model $reference, string $description): CoinTransaction
    {
        return DB::transaction(function () use ($user, $amount, $source, $reference, $description) {
            $user = User::lockForUpdate()->findOrFail($user->id);
            $balanceBefore = $user->coins_balance;
            $user->increment('coins_balance', $amount);

            return CoinTransaction::create([
                'user_id' => $user->id,
                'type' => 'credit',
                'source' => $source,
                'amount' => $amount,
                'balance_before' => $balanceBefore,
                'balance_after' => $balanceBefore + $amount,
                'reference_id' => $reference->id,
                'reference_type' => get_class($reference),
                'description' => $description,
            ]);
        });
    }

    /**
     * Debit coins from a user.
     */
    public function debit(User $user, int $amount, string $source, Model $reference, string $description): CoinTransaction
    {
        return DB::transaction(function () use ($user, $amount, $source, $reference, $description) {
            $user = User::lockForUpdate()->findOrFail($user->id);

            if ($user->coins_balance < $amount) {
                // throw new InsufficientCoinsException("رصيد الكوينز غير كافٍ");
                throw new \Exception("رصيد الكوينز غير كافٍ");
            }

            $balanceBefore = $user->coins_balance;
            $user->decrement('coins_balance', $amount);

            return CoinTransaction::create([
                'user_id' => $user->id,
                'type' => 'debit',
                'source' => $source,
                'amount' => $amount,
                'balance_before' => $balanceBefore,
                'balance_after' => $balanceBefore - $amount,
                'reference_id' => $reference->id,
                'reference_type' => get_class($reference),
                'description' => $description,
            ]);
        });
    }
}
