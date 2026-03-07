<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AuditLogController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $logs = AuditLog::with('user')
            ->when($request->search, function ($q, $s) {
                $q->where('action', 'LIKE', "%{$s}%")
                    ->orWhere('model_type', 'LIKE', "%{$s}%");
            })
            ->when($request->user_id, function ($q, $id) {
                $q->where('user_id', $id);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(50);

        return response()->json([
            'success' => true,
            'data' => $logs
        ]);
    }
}
