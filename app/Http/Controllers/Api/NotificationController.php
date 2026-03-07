<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\NotificationResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $notifications = $request->user()->notifications()->paginate(20);

        return response()->json([
            'success' => true,
            'data' => NotificationResource::collection($notifications)->response()->getData(true)
        ]);
    }

    public function markAsRead($id, Request $request): JsonResponse
    {
        $notification = $request->user()->notifications()->findOrFail($id);
        $notification->markAsRead();

        return response()->json(['success' => true, 'message' => 'تم تمييز الإشعار كمقروء.']);
    }

    public function markAllAsRead(Request $request): JsonResponse
    {
        $request->user()->unreadNotifications->markAsRead();
        return response()->json(['success' => true, 'message' => 'تم تمييز جميع الإشعارات كمقروءة.']);
    }
}
