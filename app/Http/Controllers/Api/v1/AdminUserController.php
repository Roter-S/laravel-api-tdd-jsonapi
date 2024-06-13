<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\SaveAdminUserRequest;
use App\Http\Resources\AdminUserCollection;
use App\Http\Resources\AdminUserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AdminUserController extends Controller
{

    public function index(): AdminUserCollection
    {
        $adminUsersQuery = User::allowedSorts([
            'slug',
            'name',
            'last_name',
            'email',
            'password',
            'date_of_birth',
            'phone_number',
            'status',
        ]);

        return AdminUserCollection::make($adminUsersQuery->get());
    }


    public function show(User $admin_user)
    {
        return AdminUserResource::make($admin_user);
    }

    public function store(SaveAdminUserRequest $request)
    {
        $user = User::create($request->validated());
        return AdminUserResource::make($user);
    }

    public function update(User $admin_user, SaveAdminUserRequest $request): AdminUserResource
    {
        $admin_user->update($request->validated());
        return AdminUserResource::make($admin_user);
    }

    public function destroy(User $admin_user): Response
    {
        $admin_user->delete();

        return response()->noContent();
    }
}
