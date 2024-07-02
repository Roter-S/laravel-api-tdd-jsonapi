<?php

use App\Enums\Roles;
use App\Enums\UserStatus;
use App\Models\User;

beforeEach(function () {
    User::factory(User::class)->create([
        'name' => 'John Williams',
        'last_name' => 'Doe',
        'email' => 'John@example.com',
        'date_of_birth' => '1990-01-01',
        'phone_number' => '123456789',
        'status' => UserStatus::Active,
        'roles' => [Roles::SuperAdministrator]
    ]);
    User::factory(User::class)->create([
        'name' => 'Jane Dweller',
        'last_name' => 'Cooper',
        'email' => 'Jane@example.com',
        'date_of_birth' => '1991-01-01',
        'phone_number' => '987654321',
        'status' => UserStatus::Pending,
        'roles' => [Roles::SuperAdministrator]
    ]);
});

describe('Filter admin users', function () {
    it('can filter admin users by name', function () {

        // admin-users?filter[title]=John
        $url = route('api.v1.admin-users.index', ['filter' => ['name' => 'John']]);

        $this->getJson($url)
            ->assertJsonCount(1, 'data')
            ->assertSee('John Williams')
            ->assertDontSee('Jane Dweller');
    });

    it('can filter admin users by last name', function () {

        // admin-users?filter[last_name]=Doe
        $url = route('api.v1.admin-users.index', ['filter' => ['last_name' => 'Doe']]);

        $this->getJson($url)
            ->assertJsonCount(1, 'data')
            ->assertSee('Doe')
            ->assertDontSee('Cooper');
    });

    it('can filter admin users by email', function () {

        // admin-users?filter[email]=John
        $url = route('api.v1.admin-users.index', ['filter' => ['email' => 'John']]);

        $this->getJson($url)
            ->assertJsonCount(1, 'data')
            ->assertSee('John')
            ->assertDontSee('Jane');
    });

    it('can filter admin users by date_of_birth', function () {

        // admin-users?filter[date_of_birth]=1990
        $url = route('api.v1.admin-users.index', ['filter' => ['date_of_birth' => '1990']]);

        $this->getJson($url)
            ->assertJsonCount(1, 'data')
            ->assertSee('1990')
            ->assertDontSee('1991');
    });

    it('can filter admin users by phone_number', function () {

        // admin-users?filter[phone_number]=123456789
        $url = route('api.v1.admin-users.index', ['filter' => ['phone_number' => '123456789']]);

        $this->getJson($url)
            ->assertJsonCount(1, 'data')
            ->assertSee('123456789')
            ->assertDontSee('987654321');
    });

    it('can filter admin users by status', function () {

        // admin-users?filter[status]=active
        $url = route('api.v1.admin-users.index', ['filter' => ['status' => 'active']]);

        $this->getJson($url)
            ->assertJsonCount(1, 'data')
            ->assertSee('active')
            ->assertDontSee('pending');
    });

    it('can filter admin users by roles', function () {

        // admin-users?filter[roles]=super_administrator
        $url = route('api.v1.admin-users.index', ['filter' => ['roles' => 'super_administrator']]);

        $this->getJson($url)
            ->assertJsonCount(2, 'data')
            ->assertSee('super_administrator');
    });

    it('cannot filter admin users by unknown filters', function () {

        // admin-users?filter[unknown]=value
        $url = route('api.v1.admin-users.index', ['filter' => ['unknown' => 'value']]);

        $this->getJson($url)
            ->assertStatus(400);
    });
});
