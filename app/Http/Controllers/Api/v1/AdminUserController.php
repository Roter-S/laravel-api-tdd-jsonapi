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

    public function index(Request $request): AdminUserCollection
    {
        $adminUsersQuery = User::query();

        if ($request->has('sort')) {
            // Splits the sort fields passed in the request into an array
            $sortFields = explode(',', $request->input('sort'));

            // Allowed sort fields
            $allowedSortFields = [
                'slug',
                'name',
                'last_name',
                'email',
                'password',
                'date_of_birth',
                'phone_number',
                'status',
            ];

            // Cycle through the sort fields
            foreach ($sortFields as $sortField) {

                // Determines the sort direction (ascending or descending)
                $sortDirection = str_starts_with($sortField, '-') ? 'desc' : 'asc';

                // Removes '-' sign from sort field if present
                $sortField = ltrim($sortField, '-');

                // Check if the sort field is allowed
                abort_unless(in_array($sortField, $allowedSortFields), 400, 'Invalid sort field');

                // Sort the query by the sort field
                $adminUsersQuery->orderBy($sortField, $sortDirection);
            }
        }

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
