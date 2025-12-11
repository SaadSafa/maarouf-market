<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::guard()->user();

        if (!$user) {
            return redirect()->route('login');
        }

        if ($user->role !== 'admin') {
            abort(403, 'Unauthorized access.');
        }

        $response = $next($request);

        return $response
            ->header('Cache-Control', 'no-cache, no-store, max-age=0, must-revalidate')
            ->header('Pragma', 'no-cache')
            ->header('Expires', 'Sat, 01 Jan 1990 00:00:00 GMT')
            ->header('X-Frame-Options', 'DENY')
            ->header('X-Content-Type-Options', 'nosniff')
            ->header('Referrer-Policy', 'same-origin')
            ->header('Strict-Transport-Security', 'max-age=63072000; includeSubDomains; preload')
            ->header('Permissions-Policy', 'camera=(), microphone=(), geolocation=()')
            ->header('X-Download-Options', 'noopen')
            ->header('X-Permitted-Cross-Domain-Policies', 'none');
    }
}
