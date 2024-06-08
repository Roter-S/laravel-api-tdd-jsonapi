<?php

use App\Enums\Roles;
use App\Enums\UserStatus;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

describe('Sort admin users test', function () {

    it('can sort admin user by name', function () {
        User::factory()->create(['name' => 'C Name']);
        User::factory()->create(['name' => 'A Name']);
        User::factory()->create(['name' => 'B Name']);

        $url = route('api.v1.admin-users.index', ['sort' => 'name']);
        $this->getJson($url)->assertSeeInOrder([
            'A Name',
            'B Name',
            'C Name',
        ]);
    });

    it('can sort admin user by name descending', function () {
        User::factory()->create(['name' => 'C Name']);
        User::factory()->create(['name' => 'A Name']);
        User::factory()->create(['name' => 'B Name']);

        $url = route('api.v1.admin-users.index', ['sort' => '-name']);
        $this->getJson($url)->assertSeeInOrder([
            'C Name',
            'B Name',
            'A Name',
        ]);
    });

    it('can sort admin user by last_name', function () {
        User::factory()->create(['last_name' => 'C Last Name']);
        User::factory()->create(['last_name' => 'A Last Name']);
        User::factory()->create(['last_name' => 'B Last Name']);

        $url = route('api.v1.admin-users.index', ['sort' => 'last_name']);
        $this->getJson($url)->assertSeeInOrder([
            'A Last Name',
            'B Last Name',
            'C Last Name',
        ]);
    });

    it('can sort admin user by last_name descending', function () {
        User::factory()->create(['last_name' => 'C Last Name']);
        User::factory()->create(['last_name' => 'A Last Name']);
        User::factory()->create(['last_name' => 'B Last Name']);

        $url = route('api.v1.admin-users.index', ['sort' => '-last_name']);
        $this->getJson($url)->assertSeeInOrder([
            'C Last Name',
            'B Last Name',
            'A Last Name',
        ]);
    });

    it('can sort admin user by email', function () {
        User::factory()->create(['email' => 'c@gmail.com']);
        User::factory()->create(['email' => 'a@gmail.com']);
        User::factory()->create(['email' => 'b@gmail.com']);

        $url = route('api.v1.admin-users.index', ['sort' => 'email']);
        $this->getJson($url)->assertSeeInOrder([
            'a@gmail.com',
            'b@gmail.com',
            'c@gmail.com',
        ]);
    });

    it('can sort admin user by email descending', function () {
        User::factory()->create(['email' => 'c@gmail.com']);
        User::factory()->create(['email' => 'a@gmail.com']);
        User::factory()->create(['email' => 'b@gmail.com']);

        $url = route('api.v1.admin-users.index', ['sort' => '-email']);
        $this->getJson($url)->assertSeeInOrder([
            'c@gmail.com',
            'b@gmail.com',
            'a@gmail.com',
        ]);
    });

    it('can sort admin user by date_of_birth', function () {
        User::factory()->create(['date_of_birth' => '2000-01-01']);
        User::factory()->create(['date_of_birth' => '1999-01-01']);
        User::factory()->create(['date_of_birth' => '1998-01-01']);

        $url = route('api.v1.admin-users.index', ['sort' => 'date_of_birth']);
        $this->getJson($url)->assertSeeInOrder([
            '1998-01-01',
            '1999-01-01',
            '2000-01-01',
        ]);
    });

    it('can sort admin user by date_of_birth descending', function () {
        User::factory()->create(['date_of_birth' => '2000-01-01']);
        User::factory()->create(['date_of_birth' => '1999-01-01']);
        User::factory()->create(['date_of_birth' => '1998-01-01']);

        $url = route('api.v1.admin-users.index', ['sort' => '-date_of_birth']);
        $this->getJson($url)->assertSeeInOrder([
            '2000-01-01',
            '1999-01-01',
            '1998-01-01',
        ]);
    });

    it('can sort admin user by phone_number', function () {
        User::factory()->create(['phone_number' => '123456789']);
        User::factory()->create(['phone_number' => '987654321']);
        User::factory()->create(['phone_number' => '456789123']);

        $url = route('api.v1.admin-users.index', ['sort' => 'phone_number']);
        $this->getJson($url)->assertSeeInOrder([
            '123456789',
            '456789123',
            '987654321',
        ]);
    });

    it('can sort admin user by phone_number descending', function () {
        User::factory()->create(['phone_number' => '123456789']);
        User::factory()->create(['phone_number' => '987654321']);
        User::factory()->create(['phone_number' => '456789123']);

        $url = route('api.v1.admin-users.index', ['sort' => '-phone_number']);
        $this->getJson($url)->assertSeeInOrder([
            '987654321',
            '456789123',
            '123456789',
        ]);
    });

    it('can sort admin user by status', function () {
        User::factory()->create(['status' => UserStatus::Inactive]);
        User::factory()->create(['status' => UserStatus::Active]);
        User::factory()->create(['status' => UserStatus::Blocked]);
        User::factory()->create(['status' => UserStatus::Pending]);

        $url = route('api.v1.admin-users.index', ['sort' => 'status']);
        $this->getJson($url)->assertSeeInOrder([
            'active',
            'blocked',
            'inactive',
            'pending',
        ]);
    });

    it('can sort admin user by status descending', function () {
        User::factory()->create(['status' => UserStatus::Inactive]);
        User::factory()->create(['status' => UserStatus::Active]);
        User::factory()->create(['status' => UserStatus::Blocked]);
        User::factory()->create(['status' => UserStatus::Pending]);

        $url = route('api.v1.admin-users.index', ['sort' => '-status']);
        $this->getJson($url)->assertSeeInOrder([
            'pending',
            'inactive',
            'blocked',
            'active',
        ]);
    });

    it('can sort admin user by roles', function () {
        User::factory()->create(['roles' => [Roles::SuperAdministrator->value]]);
        User::factory()->create(['roles' => [Roles::Musician->value]]);
        User::factory()->create(['roles' => [Roles::GroupAdministrator->value, Roles::Musician->value]]);

        $url = route('api.v1.admin-users.index', ['sort' => 'roles']);
        $response = $this->getJson($url);

        $data = $response->json('data');

        $this->assertEquals(
            ['group_administrator', 'musician'],
            $data[2]['attributes']['roles']
        );

        $this->assertEquals(
            ['musician'],
            $data[1]['attributes']['roles']
        );

        $this->assertEquals(
            ['super_administrator'],
            $data[0]['attributes']['roles']
        );
    });

    it('can sort admin user by roles descending', function () {
        User::factory()->create(['roles' => [Roles::SuperAdministrator->value]]);
        User::factory()->create(['roles' => [Roles::Musician->value]]);
        User::factory()->create(['roles' => [Roles::GroupAdministrator->value, Roles::Musician->value]]);

        $url = route('api.v1.admin-users.index', ['sort' => '-roles']);
        $response = $this->getJson($url);
        $data = $response->json('data');

        $this->assertEquals(
            ['super_administrator'],
            $data[0]['attributes']['roles']
        );

        $this->assertEquals(
            ['musician'],
            $data[1]['attributes']['roles']
        );

        $this->assertEquals(
            ['group_administrator', 'musician'],
            $data[2]['attributes']['roles']
        );
    });

});
