<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Report;
use App\Services\AuditLogService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $reports = Report::with(['reporter', 'reportedUser', 'reportedCoupon'])
            ->when($request->status, function ($q, $s) {
                $q->where('status', $s);
            })
            ->orderBy('created_at', 'desc')
            ->paginate();

        return response()->json(['success' => true, 'data' => $reports]);
    }

    public function resolve(Report $report, Request $request): JsonResponse
    {
        $request->validate([
            'status' => 'required|in:resolved,dismissed',
            'admin_note' => 'required|string',
        ]);

        $report->update([
            'status' => $request->status,
            'admin_note' => $request->admin_note,
            'resolved_by' => $request->user()->id,
            'resolved_at' => now(),
        ]);

        AuditLogService::log('admin_resolved_report', $report, [], $request->all());

        return response()->json(['success' => true, 'message' => 'تم إغلاق البلاغ.']);
    }
}
