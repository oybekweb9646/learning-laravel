<?php

use App\Http\Middleware\JwtAuthenticate;
use App\Http\Middleware\RoleMiddleware;
use App\Http\Middleware\SetUpLanguageMiddleware;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\App;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Symfony\Component\Routing\Exception\RouteNotFoundException;
use Tymon\JWTAuth\Exceptions\TokenBlacklistedException;


return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // $middleware->web([]);

        $middleware->api([
            SetUpLanguageMiddleware::class,
        ]);

        $middleware->alias([
            'jwt.verify' => JwtAuthenticate::class,
            'role'       => RoleMiddleware::class,
        ]);

    })
    ->withExceptions(function (Exceptions $exceptions) {

        $exceptions->render(function (Throwable $e, $request) {

            $statusCode = 500;

            if ($e instanceof AuthorizationException) {
                $statusCode = ResponseAlias::HTTP_UNAUTHORIZED;
            }
            if ($e instanceof TokenBlacklistedException) {
                $statusCode = ResponseAlias::HTTP_UNAUTHORIZED;
            }
            if ($e instanceof UnauthorizedHttpException) {
                $statusCode = ResponseAlias::HTTP_UNAUTHORIZED;
            }
            if ($e instanceof RouteNotFoundException) {
                $statusCode = ResponseAlias::HTTP_UNAUTHORIZED;
            }

            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
                'code' => $e->getCode(),
                'data' => [],
                'trace' => App::hasDebugModeEnabled() ? $e->getTrace() : [],
            ], $statusCode);
        });

    })->create();
