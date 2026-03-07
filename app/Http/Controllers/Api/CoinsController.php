<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CoinPackage;
use App\Models\CoinTopup;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

use App\Http\Resources\TransactionResource;
use App\Http\Resources\UserResource;

class CoinsController extends Controller
{
    public function balance(Request $request): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => new UserResource($request->user())
        ]);
    }

    public function transactions(Request $request): JsonResponse
    {
        $transactions = $request->user()->coinTransactions()->orderBy('created_at', 'desc')->paginate(20);
        return response()->json([
            'success' => true,
            'data' => TransactionResource::collection($transactions)->response()->getData(true)
        ]);
    }

    public function packages(): JsonResponse
    {
        $packages = CoinPackage::where('is_active', true)->orderBy('sort_order')->get();

        return response()->json([
            'success' => true,
            'data' => $packages,
        ]);
    }

    public function topup(Request $request): JsonResponse
    {
        $request->validate([
            'package_id' => 'required|exists:coin_packages,id',
            'payment_method' => 'required|in:stripe,paypal,fawry,vodafone_cash',
        ]);

        $package = CoinPackage::findOrFail($request->package_id);

        $topup = CoinTopup::create([
            'user_id' => $request->user()->id,
            'payment_gateway' => $request->payment_method,
            'amount_paid' => $package->price,
            'coins_awarded' => $package->coins_amount + $package->bonus_coins,
            'status' => 'pending',
        ]);

        // simulation: In a real app, generate payment URL or intent here

        return response()->json([
            'success' => true,
            'message' => 'تم إنشاء طلب الشحن بنجاح.',
            'data' => [
                'topup_id' => $topup->id,
                'payment_url' => 'https://payment-gateway.com/pay/' . $topup->id, // Mock
            ]
        ]);
    }
}
