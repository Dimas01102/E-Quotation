<?php
// app/Http/Middleware/AdminMiddleware.php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            if ($request->is('api/*') || $request->expectsJson()) {
                return response()->json(['success' => false, 'message' => 'Unauthorized.'], 403);
            }
            return redirect('/login')->with('error', 'Akses ditolak.');
        }
        return $next($request);
    }
}