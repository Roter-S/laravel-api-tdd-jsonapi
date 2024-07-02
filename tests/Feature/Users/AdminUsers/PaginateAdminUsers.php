<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

describe('Paginate admin users', function () {

    it('can paginate admin users', function () {
        $adminUsers = User::factory()->count(6)->create();

        $url = route('api.v1.admin-users.index', [
            'page' => [
                'size' => 2,
                'number' => 2
            ]
        ]);

        $response = $this->getJson($url);
        $response->assertSee([
            $adminUsers[2]->name,
            $adminUsers[3]->name
        ]);
        $response->assertDontSee([
            $adminUsers[0]->name,
            $adminUsers[1]->name,
            $adminUsers[4]->name,
            $adminUsers[5]->name
        ]);
        $response->assertJsonStructure([
            'links' => ['first', 'last', 'prev', 'next'],
        ]);

        $firstLink = urldecode($response->json('links.first'));
        $lastLink = urldecode($response->json('links.last'));
        $prevLink = urldecode($response->json('links.prev'));
        $nextLink = urldecode($response->json('links.next'));

        $this->assertStringContainsString('page[size]=2', $firstLink);
        $this->assertStringContainsString('page[number]=1', $firstLink);

        $this->assertStringContainsString('page[size]=2', $lastLink);
        $this->assertStringContainsString('page[number]=3', $lastLink);

        $this->assertStringContainsString('page[size]=2', $prevLink);
        $this->assertStringContainsString('page[number]=1', $prevLink);

        $this->assertStringContainsString('page[size]=2', $nextLink);
        $this->assertStringContainsString('page[number]=3', $nextLink);

    });

    it('can paginate and sort admin users', function () {
        User::factory()->create(['name' => 'C Name']);
        User::factory()->create(['name' => 'A Name']);
        User::factory()->create(['name' => 'B Name']);

        $url = route('api.v1.admin-users.index', [
            'page' => [
                'size' => 1,
                'number' => 2
            ],
            'sort' => 'name'
        ]);

        $response = $this->getJson($url);

        $response->assertSee('B Name');

        $response->assertDontSee([
            'A Name',
            'C Name'
        ]);

        $firstLink = urldecode($response->json('links.first'));
        $lastLink = urldecode($response->json('links.last'));
        $prevLink = urldecode($response->json('links.prev'));
        $nextLink = urldecode($response->json('links.next'));

        $this->assertStringContainsString('sort=name', $firstLink);
        $this->assertStringContainsString('sort=name', $lastLink);
        $this->assertStringContainsString('sort=name', $prevLink);
        $this->assertStringContainsString('sort=name', $nextLink);

    });

});
