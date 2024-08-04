<?php

use App\Models\User;


test('specific fields can be requested', function () {
    $adminUser = User::factory()->create();
    // admin-user?fields[admin-user]=name,email

    $url = route('api.v1.admin-users.index', [
        'fields' => [
            'admin-users' => 'name,email'
        ]
    ]);

    $this->getJson($url)
        ->assertJsonFragment([
            'name' => $adminUser->name,
            'email' => $adminUser->email,
        ])->assertJsonMissing([
            'id' => $adminUser->id,
            'slug' => $adminUser->slug,
            'last_name' => $adminUser->last_name,
            'password' => $adminUser->password,
            'date_of_birth' => $adminUser->date_of_birth,
            'phone_number' => $adminUser->phone_number,
            'status' => $adminUser->status,
            'roles' => $adminUser->roles,
            'instrument_id' => $adminUser->instrument_id,
            'voice_id' => $adminUser->voice_id,
            'entity_id' => $adminUser->entity_id,
            'created_at' => $adminUser->created_at,
            'updated_at' => $adminUser->updated_at,
        ]);
});
