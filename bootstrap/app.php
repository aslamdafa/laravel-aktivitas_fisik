<?php

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
        // Middleware global (jika ada) bisa ditambahkan di sini
        // $middleware->append(\App\Http\Middleware\Example::class);

        // Middleware alias (untuk penggunaan di routes)
        $middleware->alias([
            'admin' => \App\Http\Middleware\IsAdmin::class,
            'isGuru' => \App\Http\Middleware\IsGuru::class,
            'isOrangTua' => App\Http\Middleware\IsOrangTua::class,
            // Tambahkan middleware lain jika diperlukan
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        // Tempat menangani logging custom untuk error/exception
        // Misalnya $exceptions->reportable(...) atau renderable(...)
    })
    ->create();
