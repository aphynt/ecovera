<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class LockScreenMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        // Belum login → biarkan auth handle
        if (!Auth::check()) {
            return $next($request);
        }

        // Sudah login tapi terkunci → ke lock screen
        if (session('locked') && !$request->routeIs('lock.screen', 'unlock')) {
            return redirect()->route('lock.screen');
        }

        // Normal
        return $next($request);
    }
}
