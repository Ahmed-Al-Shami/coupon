<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\ReportRequest;
use App\Http\Resources\ReportResource;
use App\Models\Report;
use App\Services\AuditLogService;
use App\Services\FraudDetectionService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    protected $fraudService;

    public function __construct(FraudDetectionService $fraudService)
    {
        $this->fraudService = $fraudService;
    }

    public function store(ReportRequest $request): JsonResponse
    {
        $evidence = [];
        if ($request->hasFile('evidence_images')) {
            foreach ($request->file('evidence_images') as $image) {
                $evidence[] = $image->store('reports', 'public');
            }
        }

        $report = Report::create($request->validated() + [
            'reporter_id' => $request->user()->id,
            'evidence_images' => $evidence,
            'status' => 'pending',
        ]);

        AuditLogService::log('report_created', $report);

        // Track reporter stats
        $reporter = $request->user();
        $reporter->increment('reports_sent_count');
        $this->fraudService->checkReporterAbuse($reporter);

        // Check if reported user needs auto-suspension
        if ($report->reportedUser) {
            $report->reportedUser->increment('reports_count');
            $this->fraudService->checkUserReports($report->reportedUser);
        }

        return response()->json([
            'success' => true,
            'message' => 'تم إرسال البلاغ بنجاح.',
            'data' => new ReportResource($report->load(['reporter', 'reportedUser', 'reportedCoupon']))
        ], 201);
    }
}
