<?php

namespace App\Exceptions;

use App\Http\Responses\JsonValidationErrorResponse;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ApiValidationExceptionHandler
{
    public function handle(ValidationException $exception, Request $request): ?JsonResponse
    {
        if ($request->expectsJson()) {
            return new JsonValidationErrorResponse($exception);
        }

        return null;
    }
}


