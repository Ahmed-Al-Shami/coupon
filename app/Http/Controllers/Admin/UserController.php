<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\AuditLogService;
use App\Services\CoinService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $coinService;

    public function __construct(CoinService $coinService)
    {
        $this->coinService = $coinService;
    }

    public function index(Request $request): JsonResponse
    {
        $users = User::query()
            ->when($request->search, function ($q, $s) {
                $q->where('name', 'LIKE', "%{$s}%")->orWhere('email', 'LIKE', "%{$s}%");
            })
            ->when($request->flagged, function ($q) {
                $q->where('flagged_for_review', true);
            })
            ->paginate();

        return response()->json(['success' => true, 'data' => $users]);
    }

    public function ban(User $user, Request $request): JsonResponse
    {
        $request->validate([
            'reason' => 'required|string',
            'expires_at' => 'nullable|date|after:now',
        ]);

        $user->update([
            'is_banned' => true,
            'ban_reason' => $request->reason,
            'ban_expires_at' => $request->expires_at,
        ]);

        AuditLogService::log('admin_banned_user', $user, [], $request->all());

        return response()->json(['success' => true, 'message' => 'تم حظر المستخدم بنجاح.']);
    }

    public function unban(User $user): JsonResponse
    {
        $user->update([
            'is_banned' => false,
            'ban_reason' => null,
            'ban_expires_at' => null,
        ]);

        AuditLogService::log('admin_unbanned_user', $user);

        return response()->json(['success' => true, 'message' => 'تم إلغاء حظر المستخدم بنجاح.']);
    }

    public function adjustCoins(User $user, Request $request): JsonResponse
    {
        $request->validate([
            'amount' => 'required|integer',
            'type' => 'required|in:credit,debit',
            'description' => 'required|string',
        ]);

        if ($request->type === 'credit') {
            $this->coinService->credit($user, $request->amount, 'admin_adjustment', $request->user(), $request->description);
        } else {
            $this->coinService->debit($user, $request->amount, 'admin_adjustment', $request->user(), $request->description);
        }

        AuditLogService::log('admin_adjusted_coins', $user, [], $request->all());

        return response()->json(['success' => true, 'message' => 'تم تعديل الرصيد بنجاح.']);
    }
}
