<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PlatformSetting;
use App\Services\AuditLogService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PlatformSettingController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => PlatformSetting::all()
        ]);
    }

    public function update(Request $request): JsonResponse
    {
        $request->validate([
            'settings' => 'required|array',
            'settings.*.key' => 'required|exists:platform_settings,key',
            'settings.*.value' => 'required',
        ]);

        foreach ($request->settings as $setting) {
            $record = PlatformSetting::where('key', $setting['key'])->first();
            $oldValue = $record->value;

            $record->update([
                'value' => $setting['value'],
                'updated_by' => $request->user()->id,
            ]);

            AuditLogService::log('admin_updated_setting', null, ['old_value' => $oldValue], ['key' => $setting['key'], 'new_value' => $setting['value']]);
        }

        return response()->json([
            'success' => true,
            'message' => 'تم تحديث الإعدادات بنجاح.'
        ]);
    }
}
