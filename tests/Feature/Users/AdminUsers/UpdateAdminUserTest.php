<?php

use App\Models\User;

beforeEach(function () {
    $this->user = User::factory()->create();
});

it('can update admin users', function () {
    $user = $this->user;
    $user->name = 'Prueba de actualización';
    $response = $this->patchJson(route('api.v1.admin-users.update', $user), $user->toArray());
    $attributes = $user->toArray();
    $attributes['name'] = 'Prueba de actualización';
    expect($response->headers->get('Location'))->toBe(route('api.v1.admin-users.show', $user))
        ->and($response->json())->toMatchArray([
            'data' => [
                'type' => 'users',
                'id' => (string)$user->getRouteKey(),
                'attributes' => $attributes,
                'links' => [
                    'self' => route('api.v1.admin-users.show', $user)
                ]
            ]
        ]);
});

describe('validation errors', function () {
    it('requires a slug', function () {
        $user = $this->user;
        $userData = $user->toArray();
        $userData['slug'] = null;
        $this->patchJson(route('api.v1.admin-users.update', $user), $userData)
            ->assertJsonApiValidationErrors('slug');
    });

    it('slug must be unique', function () {
        $user = $this->user;
        $user2 = User::factory()->create([
            'email' => 'unique_email@example.com',
            'slug' => 'unique-slug'
        ]);

        $userArray = $user->toArray();
        $userArray['slug'] = $user2->slug;
        $userArray['email'] = 'another_unique_email@example.com';

        $this->patchJson(route('api.v1.admin-users.update', $user), $userArray)
            ->assertJsonApiValidationErrors('slug');
    });


    it('slug must only contain letters numbers and dashes', function () {
        $user = User::factory()->create();
        $clone = clone $user;
        unset($clone->id);
        $clone->slug = 'invalid slug';
        $this->patchJson(route('api.v1.admin-users.update', $user), $clone->toArray())
            ->assertJsonApiValidationErrors('slug');
    });

    it('slug must not contain underscores', function () {
        $user = User::factory()->create();
        $clone = clone $user;
        unset($clone->id);
        $clone->slug = 'invalid_slug';

        $this->patchJson(route('api.v1.admin-users.update', $user), $clone->toArray())
            ->assertSee(trans('validation.no_underscores', ['attribute' => 'data.attributes.slug']))
            ->assertJsonApiValidationErrors('slug');
    });

    it('slug must not start with dashes', function () {
        $user = User::factory()->create();
        $clone = clone $user;
        unset($clone->id);
        $clone->slug = '-invalid-slug';
        $this->patchJson(route('api.v1.admin-users.update', $user), $clone->toArray())
            ->assertSee(trans('validation.no_starting_dashes', ['attribute' => 'data.attributes.slug']))
            ->assertJsonApiValidationErrors('slug');
    });

    it('slug must not end with dashes', function () {
        $user = User::factory()->create();
        $clone = clone $user;
        unset($clone->id);
        $clone->slug = 'invalid-slug-';
        $this->patchJson(route('api.v1.admin-users.update', $user), $clone->toArray())
            ->assertSee(trans('validation.no_ending_dashes', ['attribute' => 'data.attributes.slug']))
            ->assertJsonApiValidationErrors('slug');
    });

    it('requires a name', function () {
        $user = $this->user;
        $user->name = null;

        $this->patchJson(route('api.v1.admin-users.update', $user), [
            'last_name' => 'Prueba de actualización'
        ])->assertJsonApiValidationErrors('name');
    });

    it('requires a last name', function () {
        $user = $this->user;
        $user->last_name = null;
        $this->patchJson(route('api.v1.admin-users.update', $user), [
            'name' => 'Prueba de actualización'
        ])->assertJsonApiValidationErrors('last_name');
    });

    it('requires an email', function () {
        $user = $this->user;
        $user->email = null;
        $this->patchJson(route('api.v1.admin-users.update', $user), [
            'name' => 'Prueba de actualización'
        ])->assertJsonApiValidationErrors('email');
    });

    it('requires a valid email', function () {
        $user = $this->user;
        $user->email = 'invalid-email';
        $this->patchJson(route('api.v1.admin-users.update', $user), [
            'name' => 'Prueba de actualización'
        ])->assertJsonApiValidationErrors('email');
    });

    it('requires a unique email', function () {
        $user = $this->user;
        $anotherUser = User::factory()->create();
        $user->email = $anotherUser->email;
        $this->patchJson(route('api.v1.admin-users.update', $user), [
            'name' => 'Prueba de actualización'
        ])->assertJsonApiValidationErrors('email');
    });

    it('password is optional', function () {
        $user = $this->user;
        $clone = clone $user;
        unset($clone->password);

        $response = $this->patchJson(route('api.v1.admin-users.update', $user), $clone->toArray());

        expect($response->headers->get('Location'))->toBe(route('api.v1.admin-users.show', $user))
            ->and($response->json())->toMatchArray([
                'data' => [
                    'type' => 'users',
                    'id' => (string)$user->getRouteKey(),
                    'attributes' => $user->toArray(),
                    'links' => [
                        'self' => route('api.v1.admin-users.show', $user)
                    ]
                ]
            ]);
    });

    it('requires a date of birth', function () {
        $user = $this->user;
        $user->date_of_birth = null;
        $this->patchJson(route('api.v1.admin-users.update', $user), [
            'name' => 'Prueba de actualización'
        ])->assertJsonApiValidationErrors('date_of_birth');
    });

    it('requires a valid date of birth', function () {
        $user = $this->user;
        $user->date_of_birth = 'invalid-date';
        $this->patchJson(route('api.v1.admin-users.update', $user), [
            'name' => 'Prueba de actualización'
        ])->assertJsonApiValidationErrors('date_of_birth');
    });

    it('requires a phone number', function () {
        $user = $this->user;
        $user->phone_number = null;
        $this->patchJson(route('api.v1.admin-users.update', $user), [
            'name' => 'Prueba de actualización'
        ])->assertJsonApiValidationErrors('phone_number');
    });

    it('requires a status', function () {
        $user = $this->user;
        $user->status = null;
        $this->patchJson(route('api.v1.admin-users.update', $user), [
            'name' => 'Prueba de actualización'
        ])->assertJsonApiValidationErrors('status');
    });

    it('requires a valid status', function () {
        $user = $this->user;
        $this->patchJson(route('api.v1.admin-users.update', $user), [
            'name' => 'Prueba de actualización',
            'status' => 'invalid-status'
        ])->assertJsonApiValidationErrors('status');
    });

    it('requires a roles', function () {
        $user = $this->user;
        $user->roles = null;
        $this->patchJson(route('api.v1.admin-users.update', $user), [
            'name' => 'Prueba de actualización'
        ])->assertJsonApiValidationErrors('roles');
    });
});
