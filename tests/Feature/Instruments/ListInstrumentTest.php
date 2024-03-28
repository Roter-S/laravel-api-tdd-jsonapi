<?php

use App\Models\Instrument;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

describe('List instrument test', function () {

    it('can fetch a single instrument', function () {
        $this->withoutExceptionHandling();

        $instrument = Instrument::factory()->create();

        $response = $this->getJson(route('api.v1.instruments.show', $instrument));

        expect($response->json())->toMatchArray([
            'data' => [
                'type' => 'instruments',
                'id' => (string)$instrument->getRouteKey(),
                'attributes' => [
                    'slug' => $instrument->slug,
                    'name' => $instrument->name,
                ],
                'links' => [
                    'self' => route('api.v1.instruments.show', $instrument),
                ],
            ],
        ]);
    });

    it('can fetch all instruments', function () {
        $this->withoutExceptionHandling();

        $instruments = Instrument::factory()->count(3)->create();

        $response = $this->getJson(route('api.v1.instruments.index'));

        expect($response->json())->toMatchArray([
            'data' => [
                [
                    'type' => 'instruments',
                    'id' => (string)$instruments[0]->getRouteKey(),
                    'attributes' => [
                        'slug' => $instruments[0]->slug,
                        'name' => $instruments[0]->name,
                    ],
                    'links' => [
                        'self' => route('api.v1.instruments.show', $instruments[0]),
                    ],
                ],
                [
                    'type' => 'instruments',
                    'id' => (string)$instruments[1]->getRouteKey(),
                    'attributes' => [
                        'slug' => $instruments[1]->slug,
                        'name' => $instruments[1]->name,
                    ],
                    'links' => [
                        'self' => route('api.v1.instruments.show', $instruments[1]),
                    ],
                ],
                [
                    'type' => 'instruments',
                    'id' => (string)$instruments[2]->getRouteKey(),
                    'attributes' => [
                        'slug' => $instruments[2]->slug,
                        'name' => $instruments[2]->name,
                    ],
                    'links' => [
                        'self' => route('api.v1.instruments.show', $instruments[2]),
                    ],
                ],
            ],
            'links' => [
                'self' => route('api.v1.instruments.index')
            ]
        ]);
    });
});
