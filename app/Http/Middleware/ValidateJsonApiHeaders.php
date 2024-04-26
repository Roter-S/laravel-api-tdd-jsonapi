<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;

class ValidateJsonApiHeaders
{
    public function handle(Request $request, Closure $next)
    {
        if ($request->header('accept') !== 'application/vnd.api+json') {
            throw new HttpException(406, __('Not Acceptable'));
        }

        if (($request->isMethod('POST') || $request->isMethod('PATCH'))
            && $request->header('content-type') !== 'application/vnd.api+json') {
            throw new HttpException(415, __('Unsupported Media Type'));
        }

        $response = $next($request);
        if ($response->status() === 204) {
            return $response;
        }

        return $response->withHeaders([
            'content-type' => 'application/vnd.api+json'
        ]);
    }
}
