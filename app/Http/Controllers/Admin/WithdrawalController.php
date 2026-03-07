<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WithdrawalRequest;
use App\Services\AuditLogService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class WithdrawalController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $withdrawals = WithdrawalRequest::with('user')
            ->when($request->status, function ($q, $s) {
                $q->where('status', $s);
            })
            ->orderBy('created_at', 'desc')
            ->paginate();

        return response()->json(['success' => true, 'data' => $withdrawals]);
    }

    public function process(WithdrawalRequest $withdrawal, Request $request): JsonResponse
    {
        $request->validate([
            'status' => 'required|in:completed,rejected',
            'admin_note' => 'nullable|string',
        ]);

        $withdrawal->update([
            'status' => $request->status,
            'admin_note' => $request->admin_note,
            'processed_by' => $request->user()->id,
            'processed_at' => now(),
        ]);

        AuditLogService::log('admin_processed_withdrawal', $withdrawal, [], $request->all());

        return response()->json(['success' => true, 'message' => 'تم معالجة طلب السحب.']);
    }
}
