<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PlatformSetting;
use Illuminate\Http\Request;

class PlatformSettingsController extends Controller
{
    public function index()
    {
        $settings = PlatformSetting::all()->pluck('value', 'key');
        return view('admin.settings', compact('settings'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'platform_commission' => 'required|numeric|min:0|max:100',
            'coin_price_egp' => 'required|numeric|min:0.01',
            'coin_release_delay' => 'required|integer|min:0',
            'suspension_threshold' => 'required|integer|min:1',
            'support_whatsapp' => 'required|string',
            'firebase_api_key' => 'nullable|string',
            'firebase_project_id' => 'nullable|string',
            'firebase_messaging_sender_id' => 'nullable|string',
            'firebase_app_id' => 'nullable|string',
            'notifications_enabled' => 'nullable|boolean',
        ]);

        foreach ($validated as $key => $value) {
            PlatformSetting::where('key', $key)->update([
                'value' => $value,
                'updated_by' => auth()->id(),
            ]);
        }

        // Specifically handle booleans if not present in request (checkboxes)
        if (!$request->has('notifications_enabled')) {
            PlatformSetting::where('key', 'notifications_enabled')->update([
                'value' => '0',
                'updated_by' => auth()->id(),
            ]);
        }

        return redirect()->back()->with('success', 'تم تحديث الإعدادات بنجاح');
    }
}
