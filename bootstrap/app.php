<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Middleware aliases
        $middleware->alias([
            'admin'    => \App\Http\Middleware\AdminMiddleware::class,
            'supplier' => \App\Http\Middleware\SupplierMiddleware::class,
        ]);

        // Stateful API — wajib agar session/cookie bekerja untuk AJAX
        $middleware->statefulApi();
    })
    ->withExceptions(function (Exceptions $exceptions) {
        // JSON response untuk API errors
        $exceptions->render(function (\Illuminate\Auth\AuthenticationException $e, Request $request) {
            if ($request->is('api/*') || $request->expectsJson()) {
                return response()->json(['success' => false, 'message' => 'Unauthenticated.'], 401);
            }
            return redirect('/login');
        });

        $exceptions->render(function (\Illuminate\Database\Eloquent\ModelNotFoundException $e, Request $request) {
            if ($request->is('api/*') || $request->expectsJson()) {
                return response()->json(['success' => false, 'message' => 'Data tidak ditemukan.'], 404);
            }
        });

        $exceptions->render(function (\Illuminate\Validation\ValidationException $e, Request $request) {
            if ($request->is('api/*') || $request->expectsJson()) {
                return response()->json(['success' => false, 'errors' => $e->errors()], 422);
            }
        });
    })
    ->create();