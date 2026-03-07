<?php

namespace App\Services;

use App\Models\WithdrawalRequest;
use App\Models\User;
use App\Models\PlatformSetting;
use App\Services\CoinService;
use Illuminate\Support\Facades\DB;
use App\Services\NotificationService;

class WithdrawalService
{
    protected $coinService;

    public function __construct(CoinService $coinService)
    {
        $this->coinService = $coinService;
    }

    public function requestWithdrawal(User $user, int $coinsAmount, string $method, array $details): WithdrawalRequest
    {
        return DB::transaction(function () use ($user, $coinsAmount, $method, $details) {
            $user = User::lockForUpdate()->findOrFail($user->id);

            $minCoins = PlatformSetting::where('key', 'withdrawal_minimum_coins')->first()->value ?? 500;
            if ($coinsAmount < $minCoins) {
                throw new \Exception("الحد الأدنى للسحب هو {$minCoins} كوينز.");
            }

            if ($user->coins_balance < $coinsAmount) {
                throw new \Exception("رصيد الكوينز غير كافٍ.");
            }

            $hasPending = WithdrawalRequest::where('user_id', $user->id)->where('status', 'pending')->exists();
            if ($hasPending) {
                throw new \Exception("لديك طلب سحب معلق بالفعل.");
            }

            $rate = PlatformSetting::where('key', 'coin_price_egp')->first()->value ?? 1.0;
            $realMoneyAmount = $coinsAmount * $rate;

            $withdrawal = WithdrawalRequest::create([
                'user_id' => $user->id,
                'coins_amount' => $coinsAmount,
                'real_money_amount' => $realMoneyAmount,
                'exchange_rate' => $rate,
                'payment_method' => $method,
                'payment_details' => $details,
                'status' => 'pending',
            ]);

            // Debit user coins immediately
            $this->coinService->debit($user, $coinsAmount, 'withdrawal', $withdrawal, "طلب سحب مبلغ: {$realMoneyAmount} جنية");

            NotificationService::send($user, 'طلب سحب جديد', "تم استلام طلب السحب الخاص بك بمبلغ {$realMoneyAmount} ج.م. جاري المراجعة.");

            return $withdrawal;
        });
    }
}
