<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureShopEnabled
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (shopEnabled()) return $next($request);

        // If request is AJAX/JSON
        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Store is currently closed. Ordering is paused.',
                'code' => 'STORE_CLOSED'
            ], 423);
        }

        return redirect()->route('home')
            ->with('store_closed', 'Store is currently closed. Ordering is paused.');
    }
}
