<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserCollection;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(): UserCollection
    {
        return UserCollection::make(User::all());
    }

    public function show(User $user)
    {
        return UserResource::make($user);
    }

    public function store(Request $request)
    {
        $request->validate([
            'data.attributes.slug' => ['required', 'string', 'unique:users,slug'],
            'data.attributes.name' => ['required', 'string'],
            'data.attributes.last_name' => ['required', 'string'],
            'data.attributes.email' => ['required', 'email', 'unique:users,email'],
            'data.attributes.password' => ['required', 'string'],
            'data.attributes.date_of_birth' => ['required', 'date'],
            'data.attributes.phone_number' => ['required', 'string'],
            'data.attributes.status' => ['required', 'boolean'],
            'data.attributes.roles' => ['required', 'string'],
            'data.attributes.instrument_id' => ['nullable', 'integer', 'exists:instruments,id'],
            'data.attributes.voice_id' => ['nullable', 'integer', 'exists:voices,id'],
            'data.attributes.entity_id' => ['nullable', 'integer', 'exists:entities,id']
        ]);

        $user = User::create($request->input('data.attributes'));

        return UserResource::make($user);
    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(string $id)
    {
        //
    }
}
