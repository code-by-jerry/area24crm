<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Redirect unauthenticated users to our named login route
        $middleware->redirectGuestsTo(fn () => route('auth.login'));

        // Redirect already-authenticated users away from guest pages
        $middleware->redirectUsersTo(fn () => route('dashboard.global'));
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        // Render our custom error pages for HTTP exceptions
        $exceptions->render(function (\Symfony\Component\HttpKernel\Exception\NotFoundHttpException $e, $request) {
            return response()->view('errors.404', [], 404);
        });

        $exceptions->render(function (\Symfony\Component\HttpKernel\Exception\HttpException $e, $request) {
            $status = $e->getStatusCode();
            $view   = "errors.{$status}";

            if (view()->exists($view)) {
                return response()->view($view, [], $status);
            }

            return response()->view('errors.500', [], $status);
        });
    })->create();
