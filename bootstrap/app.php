<?php

use App\Facades\ApiResponse;
use App\Http\Middleware\ForceJsonRequestHeader;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->append([
            ForceJsonRequestHeader::class
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        // Global Authentication Exception
        $exceptions->render(function (AuthenticationException $e, Request $request) {
            return ApiResponse::error('Unauthorized', 401);
        });

        // Global Not Found Http Exception
        $exceptions->render(function (NotFoundHttpException $e, Request $request) {
            return ApiResponse::error('Not Found', 404);
        });
    })->create();
