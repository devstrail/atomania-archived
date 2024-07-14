<?php

use App\Http\Middleware\ApiMiddleware;
use App\Http\Middleware\PermissionMiddleware;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->api(prepend: [
            ApiMiddleware::class,
        ]);

        $middleware->alias([
            'permission' => PermissionMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(function (ValidationException $exception, Request $request) {
            return response()->json([
                'error' => 'Validation Error',
                'details' => $exception->errors(),
            ], 422);
        });

        $exceptions->render(function (\Illuminate\Validation\UnauthorizedException $exception, Request $request) {
            return response()->json([
                'error' => 'Unauthorized',
                'details' => $exception->getMessage(),
            ], 401);
        });

        $exceptions->render(function (BadMethodCallException $exception, Request $request) {
            return response()->json([
                'error' => 'BadMethodCallException Error',
                'details' => [
                    'message' => $exception->getMessage(),
                    'code' => $exception->getCode(),
                    'file' => $exception->getFile(),
                    'line' => $exception->getLine(),
                    'trace' => $exception->getTrace(),
                    'previous' => $exception->getPrevious(),
                ],
            ]);
        });

        $exceptions->render(function (RuntimeException $exception, Request $request) {
            return response()->json([
                'error' => 'Unknown Error',
                'details' => $exception,
            ]);
        });
    })->create();
