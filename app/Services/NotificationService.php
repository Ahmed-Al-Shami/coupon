<?php

namespace App\Services;

use App\Models\User;
use App\Models\PlatformSetting;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class NotificationService
{
    /**
     * Send a notification to a specific user.
     */
    public static function send(User $user, string $title, string $body, array $data = [])
    {
        $enabled = PlatformSetting::where('key', 'notifications_enabled')->first()->value ?? '0';

        if ($enabled !== '1') {
            Log::info("Notifications disabled. Suppressing: [{$title}] to User {$user->id}");
            return;
        }

        // 1. Database Notification (Laravel default)
        // This assumes the user has a 'device_token' or similar if using pusher/firebase
        // For now, we manually log and record the intent.

        // 2. Firebase Cloud Messaging (FCM) logic
        self::sendToFirebase($user, $title, $body, $data);

        Log::info("Notification sent: [{$title}] to User {$user->id}");
    }

    /**
     * Dispatch to Firebase Cloud Messaging.
     */
    protected static function sendToFirebase(User $user, string $title, string $body, array $data)
    {
        $apiKey = PlatformSetting::where('key', 'firebase_api_key')->first()->value ?? null;
        $projectId = PlatformSetting::where('key', 'firebase_project_id')->first()->value ?? null;

        if (!$apiKey || !$projectId) {
            Log::warning("Firebase config missing. Skipping FCM.");
            return;
        }

        // This is a simplified FCM v1 implementation or legacy.
        // Usually requires a proper service account JSON which we don't have yet,
        // but we'll use the API key approach if applicable or at least prepare the logic.

        Log::info("FCM Dispatch planned for {$title} using Project: {$projectId}");

        // In a real implementation:
        // Http::withHeaders(['Authorization' => 'key=' . $apiKey])->post(...)
    }
}
