<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AdminAuthController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\AdminCatalogController;
use App\Http\Controllers\Api\AdminProfileController;
// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');
Route::post('/login', [AdminAuthController::class, 'login']);

Route::prefix('admin')->middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AdminAuthController::class, 'logout']);
     Route::get('/dashboard', [
        AdminAuthController::class,
        'dashboard',
    ]);
Route::group(['middleware' => 'permission:users.view'], function () {
 Route::get('/users', [
        UserController::class,
        'users',
    ]);
});
Route::group(['middleware' => 'permission:users.create'], function () {
    Route::post('/users', [
    UserController::class,
    'store',
]);
Route::get('/users/{id}', [
    UserController::class,
    'show',
]);
 Route::put('/users/{id}', [
    UserController::class,
    'update',
]);
});
Route::group(['middleware' => 'permission:categories.view'], function () {
 Route::get('/categories', [
        AdminCatalogController::class,
        'categories',
    ]);
});
Route::group(['middleware' => 'permission:products.create'], function () {
 Route::post('/products', [
        AdminCatalogController::class,
        'storeProduct',
    ]);
});
   
Route::group(['middleware' => 'permission:users.update'], function () {
Route::post(
    '/users/{id}/assign-role',
    [AdminAuthController::class, 'assignRole']
);
});
   

 
 Route::delete('/users/{id}', [
    UserController::class,
    'destroy',
]);

 

   
  Route::get('/profile', [
        AdminProfileController::class,
        'profile',
    ]);

    Route::put('/profile', [
        AdminProfileController::class,
        'updateProfile',
    ]);

    Route::put('/change-password', [
        AdminProfileController::class,
        'changePassword',
    ]);
});