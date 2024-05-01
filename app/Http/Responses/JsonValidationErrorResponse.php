<?php

namespace App\Http\Responses;

use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class JsonValidationErrorResponse extends JsonResponse
{
    public function __construct(ValidationException $exception, $status = 422)
    {
        $data = $this->formatJsonApiErrors($exception);
        $headers = ['content-type' => 'application/vnd.api+json'];
        parent::__construct($data, $status, $headers);
    }

    private function formatJsonApiErrors(ValidationException $exception): array
    {
        return [
            'errors' => collect($exception->errors())->map(function ($message, $field) {
                $fieldFormatted = '/' . str_replace('.', '/', $field);
                return [
                    'title' => 'Invalid data',
                    'detail' => $message[0],
                    'source' => ['pointer' => $fieldFormatted]
                ];
            })->values()
        ];
    }
}
