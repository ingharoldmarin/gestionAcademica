<?php

use App\Http\Controllers\Api\GenericCrudController;
use Illuminate\Support\Facades\Route;

// Generic CRUD routes for whitelisted resources
Route::prefix('v1')->group(function () {
    Route::get('{resource}', [GenericCrudController::class, 'index']);
    Route::post('{resource}', [GenericCrudController::class, 'store']);
    Route::get('{resource}/{id}', [GenericCrudController::class, 'show'])->whereNumber('id');
    Route::put('{resource}/{id}', [GenericCrudController::class, 'update'])->whereNumber('id');
    Route::patch('{resource}/{id}', [GenericCrudController::class, 'update'])->whereNumber('id');
    Route::delete('{resource}/{id}', [GenericCrudController::class, 'destroy'])->whereNumber('id');
});

