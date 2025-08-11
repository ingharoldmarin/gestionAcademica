<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\GenericCrudController;
use App\Http\Controllers\Api\RoleController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\UserRoleController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    // Auth
    Route::post('auth/register', [AuthController::class, 'register']);
    Route::post('auth/login', [AuthController::class, 'login']);

    // Protected endpoints
    Route::middleware('auth:sanctum')->group(function () {
        Route::get('auth/me', [AuthController::class, 'me']);
        Route::post('auth/logout', [AuthController::class, 'logout']);

        // Users & Roles CRUD
        Route::apiResource('users', UserController::class);
        Route::apiResource('roles', RoleController::class);

        // Admin-only: asignación de roles a usuarios
        Route::middleware('role:admin')->group(function () {
            Route::post('users/{user}/roles/sync', [UserRoleController::class, 'sync']);
            Route::post('users/{user}/roles/attach', [UserRoleController::class, 'attach']);
            Route::delete('users/{user}/roles/{role}', [UserRoleController::class, 'detach']);
        });

        // Generic CRUD routes for whitelisted resources
        Route::get('{resource}', [GenericCrudController::class, 'index']);
        Route::post('{resource}', [GenericCrudController::class, 'store']);
        Route::get('{resource}/{id}', [GenericCrudController::class, 'show'])->whereNumber('id');
        Route::put('{resource}/{id}', [GenericCrudController::class, 'update'])->whereNumber('id');
        Route::patch('{resource}/{id}', [GenericCrudController::class, 'update'])->whereNumber('id');
        Route::delete('{resource}/{id}', [GenericCrudController::class, 'destroy'])->whereNumber('id');
    });
});

