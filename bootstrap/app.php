<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )


   ->withMiddleware(function (Middleware $middleware): void {
         $middleware->alias([
        'admin' => \App\Http\Middleware\AdminMiddleware::class,
           ]);

         // Railway (FrankenPHP/Caddy) : sans proxies de confiance, les liens signés
         // (vérification email, reset mot de passe) échouent avec "Invalid signature".
         $middleware->trustProxies(at: '*');
     })	


    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->shouldRenderJsonWhen(
            fn (Request $request) => $request->is('api/*'),
        );
    })->create();
