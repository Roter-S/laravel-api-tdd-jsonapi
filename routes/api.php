<?php

use App\Http\Controllers\Api\v1\AdminUserController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->name('api.v1.')->group(function () {
    Route::apiResource('admin-users', AdminUserController::class);
});
