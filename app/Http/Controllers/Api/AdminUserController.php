<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\SaveAdminUserRequest;
use App\Http\Resources\AdminUserCollection;
use App\Http\Resources\AdminUserResource;
use App\Models\User;
use Illuminate\Http\Response;

class AdminUserController extends Controller
{
    public function index(): AdminUserCollection
    {
        return AdminUserCollection::make(User::all());
    }

    public function show(User $user)
    {
        return AdminUserResource::make($user);
    }

    public function store(SaveAdminUserRequest $request)
    {
        $user = User::create($request->validated());

        return AdminUserResource::make($user);
    }

    public function update(User $user, SaveAdminUserRequest $request)
    {
        $user->update($request->validated());
        return AdminUserResource::make($user);
    }

    public function destroy(User $user): Response
    {
        $user->delete();

        return response()->noContent();
    }
}
