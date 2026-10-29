<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
// use Throwable;
use Illuminate\Http\Request;
use Illuminate\Auth\AuthenticationException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        // admin: __DIR__.'/../routes/admin.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
        then: function () {
        Route::middleware('web')
            ->group(base_path('routes/admin.php'));
    },
    )
    ->withMiddleware(function (Middleware $middleware): void {
          $middleware->alias([
            'permission.resource' => \App\Http\Middleware\CheckPermission::class,
             'role' => \App\Http\Middleware\RoleMiddleware::class,
        ]);
       $middleware->redirectUsersTo(
        fn ($request) => route('admin.dashboard')
    );

    // Guest ko admin login page par redirect karein
    $middleware->redirectGuestsTo(
        fn (Request $request) => route('admin.login.index')
    );
    })
    ->withExceptions(function (Exceptions $exceptions): void {
           $exceptions->shouldRenderJsonWhen(
        fn (Request $request, Throwable $e) =>
            $request->is('api/*') || $request->expectsJson()
    );

    $exceptions->render(function (
        AuthenticationException $e,
        Request $request
    ) {
        if ($request->is('api/*')) {
            return response()->json([
                'success' => false,
                'message' => 'Please login first to access this resource.',
                'error' => 'UNAUTHENTICATED',
            ], 401);
        }
    });
    })->create();
