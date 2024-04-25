<?php

use App\Http\Controllers\Api\UserController;
use App\Http\Middleware\ValidateJsonApiHeaders;
use Illuminate\Support\Facades\Route;

Route::apiResource('users', UserController::class)->names('api.v1.users');
