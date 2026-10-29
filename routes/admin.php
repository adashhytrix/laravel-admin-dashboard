<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\RolePermissionController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\AdminUserController;



Route::prefix('admin')->name('admin.')->group(function () {

    // Login routes
    Route::middleware('guest:admin')->group(function () {
        Route::get('/login', [LoginController::class, 'index'])->name('login.index');
        Route::post('/login', [LoginController::class, 'login'])->name('login');
    });

    // All logged-in admins
    Route::middleware('auth:admin')->group(function () {
        Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
       // Dashboard: all allowed roles
        // Route::middleware('role:super_admin,admin,manager,staff')->group(function () {
            
            Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');
            Route::get('/charts', [DashboardController::class, 'charts'])->name('charts');
            
        // });

        // Permissions: Super Admin only
        // Route::middleware('role:super_admin')->group(function () {

                Route::get('/permissions', [PermissionController::class, 'index'])
                        ->middleware('permission.resource:permissions.view')
                        ->name('permissions.index');

                Route::get('/permissions/create', [PermissionController::class, 'create'])
                    ->middleware('permission.resource:permissions.create')
                    ->name('permissions.create');

                Route::post('/permissions', [PermissionController::class, 'store'])
                    ->middleware('permission.resource:permissions.create')
                    ->name('permissions.store');

                Route::get('/permissions/{permission}/edit', [PermissionController::class, 'edit'])
                    ->middleware('permission.resource:permissions.update')
                    ->name('permissions.edit');

                Route::put('/permissions/{permission}', [PermissionController::class, 'update'])
                    ->middleware('permission.resource:permissions.update')
                    ->name('permissions.update');

                Route::delete('/permissions/{permission}', [PermissionController::class, 'destroy'])
                    ->middleware('permission.resource:permissions.delete')
                    ->name('permissions.destroy');
        // });

        Route::get('/roles', [RoleController::class, 'index'])
            ->middleware('permission.resource:roles.view')
            ->name('roles.index');

        Route::get('/roles/create', [RoleController::class, 'create'])
            ->middleware('permission.resource:roles.create')
            ->name('roles.create');

        Route::post('/roles', [RoleController::class, 'store'])
            ->middleware('permission.resource:roles.store')
            ->name('roles.store');

        Route::get('/roles/{role}/edit', [RoleController::class, 'edit'])
            ->middleware('permission.resource:roles.edit')
            ->name('roles.edit');

        Route::put('/roles/{role}', [RoleController::class, 'update'])
            ->middleware('permission.resource:roles.update')
            ->name('roles.update');

        // Current admin's own profile
        Route::get('/user/profile', [ProfileController::class, 'index'])
            ->middleware('permission.resource:profile.view')
            ->name('profile.index');

        Route::put('/user/profile', [ProfileController::class, 'update'])
        ->middleware('permission.resource:profile.update')
            ->name('user.update');

        // Users: permissions checked by CheckPermission middleware
        Route::get('/user/user-list', [UserController::class, 'index'])
            ->middleware('permission.resource:users.view')
            ->name('user.index');

        Route::get('/user/create', [UserController::class, 'create'])
            ->middleware('permission.resource:users.create')
            ->name('user.create');

          
        Route::post('/user/store', [UserController::class, 'store'])
            ->middleware('permission.resource:users.store')
            ->name('user.store');

        // Route::get('/user/{user}/edit', [UserController::class, 'edit'])
        //     // ->middleware('permission.resource:users.edit')
        //     ->name('user.edit');

     
        Route::delete('/user/{user}', [UserController::class, 'destroy'])
            ->middleware('permission.resource:users.destroy')
            ->name('user.destroy');


            Route::get('/users', [AdminUserController::class, 'index'])
            ->middleware('permission.resource:users.view')
    ->name('users.index');

        Route::get('/users/create', [AdminUserController::class, 'create'])
          ->middleware('permission.resource:users.create')
            ->name('users.create');

        Route::post('/users', [AdminUserController::class, 'store'])
         ->middleware('permission.resource:users.store')
            ->name('users.store');

        Route::get('/users/{user}/edit', [AdminUserController::class, 'edit'])
        //  ->middleware('permission.resource:users.edit')
            ->name('users.edit');

        Route::put('/users/{user}', [AdminUserController::class, 'update'])
         ->middleware('permission.resource:users.update')
            ->name('users.update');
            });
});