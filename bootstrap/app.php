<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

use Illuminate\Auth\Middleware\Authenticate;
use Illuminate\Auth\Middleware\RedirectIfAuthenticated;
use App\Http\Middleware\AdminMiddleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withMiddleware(function (Middleware $middleware): void {
    $middleware->alias([
        'auth' => Authenticate::class,
        'guest' => RedirectIfAuthenticated::class,
        'admin' => AdminMiddleware::class,
    ]);
})

->withRouting(
     web: [
        __DIR__.'/../routes/web.php',
        __DIR__.'/../routes/admin.php',
    ],
    commands: __DIR__.'/../routes/console.php',
    health: '/up',
)

    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })
    ->create();