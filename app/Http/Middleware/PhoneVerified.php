<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class PhoneVerified
{
    public function handle(Request $request, Closure $next)
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        if (!auth()->user()->phone_verified_at) {
            return redirect()->route('phone.verify.page')
                ->with('error', 'You must verify your phone to continue.');
        }

        return $next($request);
    }
}
