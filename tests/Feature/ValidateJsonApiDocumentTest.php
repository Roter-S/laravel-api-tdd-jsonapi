<?php

use App\Http\Middleware\ValidateJsonApiDocument;
use Illuminate\Support\Facades\Route;

describe('Validate json api headers test', function () {

    beforeEach(function () {
        Route::any('test_route', fn() => response()->json(['message' => 'success']))
            ->middleware(ValidateJsonApiDocument::class);
    });

    it('data is required', function () {
        $this->postJson('test_route', [])
            ->assertJsonApiValidationErrors('data');

        $this->patchJson('test_route', [])
            ->assertJsonApiValidationErrors('data');
    });

    it('data must be an array', function () {
        $this->postJson('test_route', ['data' => 'not-an-array'])
            ->assertJsonApiValidationErrors('data');

        $this->patchJson('test_route', ['data' => 'not-an-array'])
            ->assertJsonApiValidationErrors('data');
    });

    it('data type is required', function () {
        $this->postJson('test_route', ['data' => [
            'type' => 123,
            'attributes' => ['name' => 'test'],
        ]])->assertJsonApiValidationErrors('data.type');

        $this->patchJson('test_route', ['data' => [
            'type' => 123,
            'attributes' => ['name' => 'test']
        ]])->assertJsonApiValidationErrors('data.type');
    });

    it('data type must be a string', function () {
        $this->postJson('test_route', ['data' => [
            'type' => 123,
            'attributes' => ['name' => 'test'],
        ]])->assertJsonApiValidationErrors('data.type');

        $this->patchJson('test_route', ['data' => [
            'type' => 123,
            'attributes' => ['name' => 'test']
        ]])->assertJsonApiValidationErrors('data.type');
    });

    it('data attribute is required', function () {
        $this->postJson('test_route', ['data' => [
            'type' => 'test',
        ]])->assertJsonApiValidationErrors('data.attributes');

        $this->patchJson('test_route', ['data' => [
            'type' => 'test',
        ]])->assertJsonApiValidationErrors('data.attributes');
    });

    it('data attribute must be an array', function () {
        $this->postJson('test_route', ['data' => [
            'type' => 'test',
            'attributes' => 'not-an-array',
        ]])->assertJsonApiValidationErrors('data.attributes');

        $this->patchJson('test_route', ['data' => [
            'type' => 'test',
            'attributes' => 'not-an-array',
        ]])->assertJsonApiValidationErrors('data.attributes');
    });

    it('data id is required for PATCH requests', function () {
        $this->patchJson('test_route', [
            'data' => [
                'type' => 'test',
                'attributes' => ['name' => 'test'],
            ]
        ])->assertJsonApiValidationErrors('data.id');
    });

    it('data id must be a string', function () {
        $this->patchJson('test_route', [
            'data' => [
                'type' => 'test',
                'id' => 123,
                'attributes' => ['name' => 'test'],
            ]
        ])->assertJsonApiValidationErrors('data.id');
    });

    it('only accepts valid json api document', function () {
        $this->postJson('test_route', [
            'data' => [
                'type' => 'test',
                'attributes' => ['name' => 'test'],
            ]
        ])->assertSuccessful();

        $this->patchJson('test_route', [
            'data' => [
                'id' => '123',
                'type' => 'test',
                'attributes' => ['name' => 'test'],
            ]
        ])->assertSuccessful();
    });
});
