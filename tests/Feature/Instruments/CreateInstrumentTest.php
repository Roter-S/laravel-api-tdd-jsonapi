<?php

use App\Models\Instrument;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('can create instruments', function () {
    $this->withoutExceptionHandling();

    $response = $this->postJson(route('api.v1.instruments.store'), [
        'data' => [
            'type' => 'instruments',
            'attributes' => [
                'slug' => 'guitar',
                'name' => 'Guitar',
                'type' => 'String'
            ]
        ]
    ]);

    $instrument = Instrument::first();

    expect($response->status())->toBe(201)
        ->and($response->headers->get('Location'))->toBe(route('api.v1.instruments.show', $instrument))
        ->and($response->json())->toMatchArray([
            'data' => [
                'type' => 'instruments',
                'id' => (string)$instrument->getRouteKey(),
                'attributes' => [
                    'slug' => 'guitar',
                    'name' => 'Guitar',
                    'type' => 'String'
                ],
                'links' => [
                    'self' => route('api.v1.instruments.show', $instrument)
                ]
            ]
        ]);
});
