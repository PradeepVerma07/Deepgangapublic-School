<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
        then: function () {
            // Admin routes
            if (file_exists(base_path('routes/admin.php'))) {
                Route::middleware('web')
                    ->prefix('admin')
                    ->name('admin.')
                    ->group(base_path('routes/admin.php'));
            }
        }
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'admin.guest' => \App\Http\Middleware\AdminGuest::class,
            'admin.auth' => \App\Http\Middleware\AdminAuth::class,
            'role.menu.access' => \App\Http\Middleware\CheckRoleMenuAccess::class,
        ]);

        $middleware->redirectTo(function (Request $request) {

            $middleware = $request->route() ? $request->route()->middleware() : [];
            if (in_array('admin.guest', $middleware)) {
                return '/admin/login';
            }
            if (in_array('admin.auth', $middleware)) {
                return '/admin/dashboard';
            }
            return $request->user() ? '/admin/dashboard' : '/admin/login';
        });
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
