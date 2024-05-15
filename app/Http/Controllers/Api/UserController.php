<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\SaveUserRequest;
use App\Http\Resources\UserCollection;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

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

    public function store(SaveUserRequest $request)
    {
        $user = User::create($request->validated());

        return UserResource::make($user);
    }

    public function update(User $user, SaveUserRequest $request)
    {
        $user->update($request->validated());
        return UserResource::make($user);
    }

    public function destroy(User $user): Response
    {
        $user->delete();

        return response()->noContent();
    }
}
