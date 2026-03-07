<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class FingerprintRequest
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Simple fingerprinting: User-Agent + Accept-Language + Custom Header
        $userAgent = $request->userAgent();
        $acceptLang = $request->header('Accept-Language');
        $customHeader = $request->header('X-Device-Fingerprint'); // Expected from client

        $fingerprint = hash('sha256', $userAgent . $acceptLang . $customHeader);

        $request->merge(['device_fingerprint_calculated' => $fingerprint]);

        return $next($request);
    }
}
