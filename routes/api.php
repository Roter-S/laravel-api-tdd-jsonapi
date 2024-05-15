<?php

use App\Http\Controllers\Api\AdminUserController;
use App\Http\Middleware\ValidateJsonApiHeaders;
use Illuminate\Support\Facades\Route;

Route::apiResource('users', AdminUserController::class)->names('api.v1.users');
