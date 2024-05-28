<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Illuminate\Testing\TestResponse;
use PHPUnit\Framework\Assert as PHPUnit;
use PHPUnit\Framework\ExpectationFailedException;

class JsonApiServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        TestResponse::macro('assertJsonApiValidationErrors', $this->assertJsonApiValidationErrors());
    }

    private function assertJsonApiValidationErrors(): \Closure
    {
        return function ($attribute) {
            $pointer = Str::of($attribute)->startsWith('data')
                ? "/". Str::replace('.', '/', $attribute)
                : "/data/attributes/$attribute";

            try {
                $this->assertJsonFragment([
                    'source' => ['pointer' => $pointer],
                ]);
            } catch (ExpectationFailedException $e) {
                PHPUnit::fail("Failed to find a JSON:API validation error for key: '$attribute'"
                    . PHP_EOL . PHP_EOL .
                    $e->getMessage());
            }
            try {
                $this->assertJsonStructure([
                    'errors' => [
                        ['title', 'detail', 'source' => ['pointer']]
                    ]
                ]);
            } catch (ExpectationFailedException $e) {
                PHPUnit::fail("Failed to find a valid JSON:API error response"
                    . PHP_EOL . PHP_EOL .
                    $e->getMessage());
            }
            expect($this->status())->toBe(422)
                ->and($this->headers->get('content-type'))->toBe('application/vnd.api+json');
        };
    }
}
