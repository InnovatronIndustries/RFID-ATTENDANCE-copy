<?php

use App\Http\Controllers\CMS\{
    RoleController,
    UserController
};

use Illuminate\Support\Facades\Route;

Route::prefix('access-management')->group(function () {
    Route::resource('roles', RoleController::class)->only(['index']);
    Route::resource('users', UserController::class)->except(['show']);
});