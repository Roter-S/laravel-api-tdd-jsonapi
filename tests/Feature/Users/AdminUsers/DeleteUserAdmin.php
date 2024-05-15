<?php

use App\Models\User;

test('can delete admin user', function () {
    $user = User::factory()->create();

    $response = $this->deleteJson(route('api.v1.users.destroy', $user));

    expect($response->status())->toBe(204)
        ->and(User::count())->toBe(0);
});
