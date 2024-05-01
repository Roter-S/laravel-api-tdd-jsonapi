<?php

use App\Http\Middleware\ValidateJsonApiHeaders;
use Illuminate\Support\Facades\Route;

describe('Validate json api headers test', function () {

    beforeEach(function () {
        $this->withoutJsonApiDocumentFormatting();
        Route::any('test_route', fn() => response()->json(['message' => 'success']))
            ->middleware(ValidateJsonApiHeaders::class);
    });

    it('accept header must be present in all requests', function () {
        $this->getJson('test_route')->assertSuccessful();
    });

    it('content type header must be present in all post requests', function () {
        $this->postJson('test_route', [
            'data' => [
                'type' => 'test',
                'attributes' => ['name' => 'test'],
            ]
        ], [
            'content-type' => 'application/vnd.api+json'
        ])->assertSuccessful();
    });

    it('content type header must be present in all patch requests', function () {
        $this->patchJson('test_route', [
            'data' => [
                'id' => '1',
                'type' => 'test',
                'attributes' => ['name' => 'test'],
            ]
        ], [
            'content-type' => 'application/vnd.api+json'
        ])->assertSuccessful();
    });

    it('content type header must be present in responses', function () {
        $this->getJson('test_route')->assertHeader('content-type', 'application/vnd.api+json');

        $this->postJson('test_route', [], [
            'content-type' => 'application/vnd.api+json'
        ])->assertHeader('content-type', 'application/vnd.api+json');

        $this->patchJson('test_route', [], [
            'content-type' => 'application/vnd.api+json'
        ])->assertHeader('content-type', 'application/vnd.api+json');
    });

    it('content type header must not be present in empty responses', function () {
        Route::any('empty_response', fn() => response()->noContent())
            ->middleware(ValidateJsonApiHeaders::class);

        $this->getJson('empty_response')->assertHeaderMissing('content-type');

        $this->postJson('empty_response', [
            'data' => [
                'type' => 'test',
                'attributes' => ['name' => 'test'],
            ]
        ], [
            'content-type' => 'application/vnd.api+json'
        ])->assertHeaderMissing('content-type');

        $this->patchJson('empty_response', [
            'data' => [
                'id' => '1',
                'type' => 'test',
                'attributes' => ['name' => 'test'],
            ]
        ], [
            'content-type' => 'application/vnd.api+json'
        ])->assertHeaderMissing('content-type');

        $this->deleteJson('empty_response', [], [
            'content-type' => 'application/vnd.api+json'
        ])->assertHeaderMissing('content-type');
    });
});
