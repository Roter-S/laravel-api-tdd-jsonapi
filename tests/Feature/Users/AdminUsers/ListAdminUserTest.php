<?php

use App\Models\User;

describe('List user test', function () {

    it('can fetch a single user', function () {
        $this->withoutExceptionHandling();

        $user = User::factory()->create();

        $response = $this->getJson(route('api.v1.admin-users.show', $user));

        expect($response->json())->toMatchArray([
            'data' => [
                'type' => 'users',
                'id' => (string)$user->getRouteKey(),
                'attributes' => $user->toArray(),
                'links' => [
                    'self' => route('api.v1.admin-users.show', $user),
                ],
            ],
        ]);
    });

    it('can fetch all users', function () {
        $this->withoutExceptionHandling();

        $users = User::factory()->count(3)->create();
        $response = $this->getJson(route('api.v1.admin-users.index'));

        $response->assertJson([
            'data' => [
                [
                    'type' => 'users',
                    'id' => (string)$users[0]->getRouteKey(),
                    'attributes' => $users->toArray()[0],
                    'links' => [
                        'self' => route('api.v1.admin-users.show', $users[0]),
                    ],
                ],
                [
                    'type' => 'users',
                    'id' => (string)$users[1]->getRouteKey(),
                    'attributes' => $users->toArray()[1],
                    'links' => [
                        'self' => route('api.v1.admin-users.show', $users[1]),
                    ],
                ],
                [
                    'type' => 'users',
                    'id' => (string)$users[2]->getRouteKey(),
                    'attributes' => $users->toArray()[2],
                    'links' => [
                        'self' => route('api.v1.admin-users.show', $users[2]),
                    ],
                ],
            ],
            'links' => [
                'self' => route('api.v1.admin-users.index')
            ]
        ]);
    });
});
