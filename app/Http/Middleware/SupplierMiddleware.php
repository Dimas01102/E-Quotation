<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SupplierMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check() || Auth::user()->role !== 'supplier') {
            if ($request->is('api/*') || $request->expectsJson()) {
                return response()->json(['success' => false, 'message' => 'Unauthorized.'], 403);
            }
            return redirect('/login')->with('error', 'Akses ditolak.');
        }

        if (!Auth::user()->is_active) {
            if ($request->is('api/*') || $request->expectsJson()) {
                return response()->json(['success' => false, 'message' => 'Akun belum aktif.'], 403);
            }
            Auth::logout();
            return redirect('/login')->with('error', 'Akun belum aktif. Hubungi admin.');
        }

        return $next($request);
    }
}