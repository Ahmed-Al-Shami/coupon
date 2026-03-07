<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CoinPackage;
use App\Services\AuditLogService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PackageController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => CoinPackage::orderBy('sort_order')->get()
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'coins_amount' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
            'currency' => 'required|string|size:3',
            'bonus_coins' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
            'sort_order' => 'integer',
        ]);

        $package = CoinPackage::create($validated);

        AuditLogService::log('admin_created_package', $package);

        return response()->json([
            'success' => true,
            'message' => 'تم إنشاء باقة الكوينات بنجاح.',
            'data' => $package
        ], 201);
    }

    public function update(Request $request, CoinPackage $package): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'string',
            'coins_amount' => 'integer|min:1',
            'price' => 'numeric|min:0',
            'currency' => 'string|size:3',
            'bonus_coins' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
            'sort_order' => 'integer',
        ]);

        $package->update($validated);

        AuditLogService::log('admin_updated_package', $package, [], $validated);

        return response()->json([
            'success' => true,
            'message' => 'تم تحديث الباقة بنجاح.',
            'data' => $package
        ]);
    }

    public function destroy(CoinPackage $package): JsonResponse
    {
        $package->delete();
        AuditLogService::log('admin_deleted_package', $package);

        return response()->json([
            'success' => true,
            'message' => 'تم حذف الباقة بنجاح.'
        ]);
    }
}
