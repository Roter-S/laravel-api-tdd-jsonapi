<?php

namespace App\Http\Controllers\Api\v1;

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
        $sortField = request('sort', 'id');
        $sortDirection = str_starts_with($sortField, '-') ? 'desc' : 'asc';
        $sortField = ltrim($sortField, '-');

        $adminUsers = User::all();

        $adminUsers = $adminUsers->sortBy(function ($user) use ($sortField) {
            $value = $user->$sortField;

            if ($value instanceof \BackedEnum) {
                $value = $value->value;
            }
            if (isJsonField($sortField, ['roles'])) {
                $jsonData = is_array($value) ? $value : json_decode($value, true);
                return is_array($jsonData) ? implode(',', $jsonData) : '';
            }

            return $value;
        }, SORT_REGULAR, $sortDirection === 'desc');

        return AdminUserCollection::make($adminUsers);
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
