<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->user = User::factory()->create(['status' => true]);
});

it('can update admin users', function () {
    $user = $this->user;
    $user->name = 'Prueba de actualización';
    $response = $this->patchJson(route('api.v1.users.update', $user), $user->toArray())->assertOk();

    $attributes = $user->toArray();
    $attributes['name'] = 'Prueba de actualización';
    expect($response->headers->get('Location'))->toBe(route('api.v1.users.show', $user))
        ->and($response->json())->toMatchArray([
            'data' => [
                'type' => 'users',
                'id' => (string)$user->getRouteKey(),
                'attributes' => $attributes,
                'links' => [
                    'self' => route('api.v1.users.show', $user)
                ]
            ]
        ]);
});

describe('validation errors', function () {
    it('requires a slug', function () {
        $user = $this->user;
        $user->slug = null;
        $this->patchJson(route('api.v1.users.update', $user), [
            'name' => 'Prueba de actualización'
        ])->assertJsonApiValidationErrors('slug');
    });

    it('requires a name', function () {
        $user = $this->user;
        $user->name = null;

        $this->patchJson(route('api.v1.users.update', $user), [
            'last_name' => 'Prueba de actualización'
        ])->assertJsonApiValidationErrors('name');
    });

    it('requires a last name', function () {
        $user = $this->user;
        $user->last_name = null;
        $this->patchJson(route('api.v1.users.update', $user), [
            'name' => 'Prueba de actualización'
        ])->assertJsonApiValidationErrors('last_name');
    });

    it('requires an email', function () {
        $user = $this->user;
        $user->email = null;
        $this->patchJson(route('api.v1.users.update', $user), [
            'name' => 'Prueba de actualización'
        ])->assertJsonApiValidationErrors('email');
    });

    it('requires a valid email', function () {
        $user = $this->user;
        $user->email = 'invalid-email';
        $this->patchJson(route('api.v1.users.update', $user), [
            'name' => 'Prueba de actualización'
        ])->assertJsonApiValidationErrors('email');
    });

    it('requires a unique email', function () {
        $user = $this->user;
        $anotherUser = User::factory()->create();
        $user->email = $anotherUser->email;
        $this->patchJson(route('api.v1.users.update', $user), [
            'name' => 'Prueba de actualización'
        ])->assertJsonApiValidationErrors('email');
    });

    it('password is optional', function () {
        $user = $this->user;
        $user->name = 'Prueba de actualización';
        $user->password = null;
        $this->patchJson(route('api.v1.users.update', $user), $user->toArray())->assertOk();
    });

    it('requires a date of birth', function () {
        $user = $this->user;
        $user->date_of_birth = null;
        $this->patchJson(route('api.v1.users.update', $user), [
            'name' => 'Prueba de actualización'
        ])->assertJsonApiValidationErrors('date_of_birth');
    });

    it('requires a valid date of birth', function () {
        $user = $this->user;
        $user->date_of_birth = 'invalid-date';
        $this->patchJson(route('api.v1.users.update', $user), [
            'name' => 'Prueba de actualización'
        ])->assertJsonApiValidationErrors('date_of_birth');
    });

    it('requires a phone number', function () {
        $user = $this->user;
        $user->phone_number = null;
        $this->patchJson(route('api.v1.users.update', $user), [
            'name' => 'Prueba de actualización'
        ])->assertJsonApiValidationErrors('phone_number');
    });

    it('requires a status', function () {
        $user = $this->user;
        $user->status = null;
        $this->patchJson(route('api.v1.users.update', $user), [
            'name' => 'Prueba de actualización'
        ])->assertJsonApiValidationErrors('status');
    });

    it('requires a valid status', function () {
        $user = $this->user;
        $user->status = 'invalid-status';
        $this->patchJson(route('api.v1.users.update', $user), [
            'name' => 'Prueba de actualización'
        ])->assertJsonApiValidationErrors('status');
    });

    it('requires a roles', function () {
        $user = $this->user;
        $user->roles = null;
        $this->patchJson(route('api.v1.users.update', $user), [
            'name' => 'Prueba de actualización'
        ])->assertJsonApiValidationErrors('roles');
    });
});
