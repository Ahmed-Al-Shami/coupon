<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\LoginRequest;
use App\Http\Requests\Api\RegisterRequest;
use App\Models\User;
use App\Services\AuditLogService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function register(RegisterRequest $request): JsonResponse
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'ip_address' => $request->ip(),
            'device_fingerprint' => $request->header('X-Device-Fingerprint'),
        ]);

        // In a real app, send OTP here

        AuditLogService::log('user_registered', $user);

        return response()->json([
            'success' => true,
            'message' => 'تم التسجيل بنجاح. يرجى التحقق من بريدك الإلكتروني وهاتفك.',
            'data' => [
                'user' => $user,
                'token' => $user->createToken($request->device_name)->plainTextToken,
            ]
        ], 201);
    }

    public function login(LoginRequest $request): JsonResponse
    {
        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            AuditLogService::log('login_failed', null, ['email' => $request->email]);
            throw ValidationException::withMessages([
                'email' => ['بيانات الاعتماد غير صحيحة.'],
            ]);
        }

        if ($user->is_banned) {
            return response()->json([
                'success' => false,
                'message' => 'هذا الحساب محظور. السبب: ' . $user->ban_reason,
            ], 403);
        }

        $user->update([
            'last_login_at' => now(),
            'ip_address' => $request->ip(),
            'device_fingerprint' => $request->header('X-Device-Fingerprint'),
        ]);

        AuditLogService::log('user_logged_in', $user);

        return response()->json([
            'success' => true,
            'message' => 'تم تسجيل الدخول بنجاح.',
            'data' => [
                'user' => $user,
                'token' => $user->createToken($request->device_name)->plainTextToken,
            ]
        ]);
    }

    public function logout(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()->delete();

        AuditLogService::log('user_logged_out', $request->user());

        return response()->json([
            'success' => true,
            'message' => 'تم تسجيل الخروج بنجاح.',
        ]);
    }

    public function logoutAll(Request $request): JsonResponse
    {
        $request->user()->tokens()->delete();

        AuditLogService::log('user_logged_out_all', $request->user());

        return response()->json([
            'success' => true,
            'message' => 'تم تسجيل الخروج من جميع الأجهزة بنجاح.',
        ]);
    }
}
