<?php

use App\Http\Middleware\ValidateJsonApiDocument;
use App\Http\Middleware\ValidateJsonApiHeaders;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
        apiPrefix: '/api/v1',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->append(ValidateJsonApiHeaders::class);
        $middleware->append(ValidateJsonApiDocument::class);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(function (ValidationException $exception, Request $request) {
            if ($request->expectsJson()) {
                $errors = $exception->errors();
                return response()->json([
                    'errors' => collect($errors)->map(function ($message, $field) use (&$customErrors) {
                        $fieldFormatted = '/' . str_replace('.', '/', $field);
                        return [
                            'title' => 'Invalid data',
                            'detail' => $message[0],
                            'source' => ['pointer' => $fieldFormatted]
                        ];
                    })->values()
                ], 422, ['content-type' => 'application/vnd.api+json']);
            }
            return response()->withErrors($exception->validator->errors());
        });
    })
    ->create();
