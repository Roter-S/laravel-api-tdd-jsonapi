<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('can delete admin user', function () {
    $user = User::factory()->create();

    $response = $this->deleteJson(route('api.v1.admin-users.destroy', $user));
    expect($response->status())->toBe(204)
        ->and(User::count())->toBe(0);
});
