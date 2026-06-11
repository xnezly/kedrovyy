<?php

use App\Http\Middleware\AdminMiddleware;
use Illuminate\Http\Exceptions\PostTooLargeException;
use Illuminate\Http\Request;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'admin' => AdminMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(function (PostTooLargeException $exception, Request $request) {
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Слишком большой размер загружаемых файлов. Уменьшите количество фотографий или их размер.',
                ], 413);
            }

            return back()->withErrors([
                'images' => 'Слишком большой общий размер загружаемых файлов. Загружайте не более 15 фото, до 10 МБ каждое и примерно до 48 МБ за один раз.',
            ]);
        });
    })->create();
