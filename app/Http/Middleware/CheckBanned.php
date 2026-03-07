<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckBanned
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->user() && $request->user()->is_banned) {
            return response()->json([
                'success' => false,
                'message' => 'Your account is banned. Reason: ' . ($request->user()->ban_reason ?? 'No reason provided.'),
            ], 403);
        }

        return $next($request);
    }
}
