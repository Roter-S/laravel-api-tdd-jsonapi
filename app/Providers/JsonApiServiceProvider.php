<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Testing\TestResponse;

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
        TestResponse::macro('assertJsonApiValidationErrors', function ($attribute) {
            $detailAttribute = str_replace('_', ' ', $attribute);
            expect($this->status())->toBe(422)
                ->and($this->headers->get('content-type'))->toBe('application/vnd.api+json')
                ->and($this->assertJsonStructure([
                    'errors' => [
                        ['title', 'detail', 'source' => ['pointer']]
                    ]
                ])->assertJsonFragment([
                    'source' => ['pointer' => "/data/attributes/$attribute"],
                ]));
        });
    }
}
