<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {
    Route::post('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:api')->name('logout');
    Route::post('/refresh', [AuthController::class, 'refresh'])->middleware('auth:api')->name('refresh');
});
Route::get('users', [UserController::class, 'index']);
Route::get('users/{user}', [UserController::class, 'show']);
Route::post('update-user/{user}', [UserController::class, 'update'])->middleware('auth:api');
Route::delete('delete-user/{id}', [UserController::class, 'destroy']);
// Route::middleware('role:admin')->group(function () {
//     // Routes accessible only by admin
// });

// Route::middleware('role:manager')->group(function () {
//     // Routes accessible only by manager
// });
// // Routes accessible by admin or manager
// Route::middleware('role:admin,manager')->group(function () {
//     Route::get('/admin-dashboard', [AdminController::class, 'index']);
//     Route::post('/tasks/assign', [TaskController::class, 'assignTask']);
// });

// // Routes accessible by task users (workers)
// Route::middleware('role:task_user')->group(function () {
//     Route::get('/tasks', [TaskController::class, 'index']);
// });