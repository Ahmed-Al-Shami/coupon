<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\WithdrawalRequest as WithdrawalFormRequest;
use App\Http\Resources\WithdrawalResource;
use App\Services\WithdrawalService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class WithdrawalController extends Controller
{
    protected $withdrawalService;

    public function __construct(WithdrawalService $withdrawalService)
    {
        $this->withdrawalService = $withdrawalService;
    }

    public function index(Request $request): JsonResponse
    {
        $withdrawals = $request->user()->withdrawalRequests()
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return response()->json([
            'success' => true,
            'data' => WithdrawalResource::collection($withdrawals)->response()->getData(true),
        ]);
    }

    public function store(WithdrawalFormRequest $request): JsonResponse
    {
        try {
            $withdrawal = $this->withdrawalService->requestWithdrawal(
                $request->user(),
                $request->coins_amount,
                $request->payment_method,
                $request->payment_details
            );

            return response()->json([
                'success' => true,
                'message' => 'تم تقديم طلب السحب بنجاح.',
                'data' => new WithdrawalResource($withdrawal),
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 400);
        }
    }
}
