<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminOnly
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Assuming we use a simple check or a role system later
        // For now, let's assume users with email ending in @couponx.com are admins
        // Or we can add an is_admin flag. Let's add is_admin flag to User model soon.
        // Actually, let's use a setting or a simple check for now.
        if (!$request->user() || !$request->user()->is_admin) {
            return response()->json(['success' => false, 'message' => 'غير مصرح لك بالدخول لهذه الصفحة.'], 403);
        }

        return $next($request);
    }
}
