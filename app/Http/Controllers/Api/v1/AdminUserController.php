<?php

namespace App\Http\Controllers\Api\v1;

use App\Enums\Roles;
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
        $adminUsersQuery = User::query();

        $allowedFilters = [
            'name',
            'last_name',
            'email',
            'date_of_birth',
            'phone_number',
            'status',
            'roles'
        ];

        foreach (request('filter', []) as $filter => $value) {
            abort_unless(in_array($filter, $allowedFilters), 400, 'Filter not allowed');
            $adminUsersQuery->where($filter, 'like', '%' . $value . '%');
        }

        $adminUsersQuery->allowedSorts([
            'slug',
            'name',
            'last_name',
            'email',
            'password',
            'date_of_birth',
            'phone_number',
            'status',
        ]);

        return AdminUserCollection::make($adminUsersQuery->jsonPaginate());
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
