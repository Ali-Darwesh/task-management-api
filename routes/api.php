<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::group([
    'middleware' => 'api',
], function ($router) {
    Route::post('/users', [AuthController::class, 'register'])->name('register');
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:api')->name('logout');
    Route::post('/refresh', [AuthController::class, 'refresh'])->middleware('auth:api')->name('refresh');
});
Route::get('users', [UserController::class, 'index'])->middleware('role:admin');
Route::get('users/{id}', [UserController::class, 'show'])->middleware('role:admin');
Route::post('update-user/{id}', [UserController::class, 'update'])->middleware('role:admin');
Route::delete('users/{id}', [UserController::class, 'softDelete'])->middleware('role:admin');
Route::post('users/{id}/restore', [UserController::class, 'restore'])->middleware('role:admin');
Route::delete('users/{id}/force', [UserController::class, 'forceDelete'])->middleware('role:admin');



//======================department
Route::post('departments', [DepartmentController::class, 'store'])->middleware('role:admin');

//=========assign task to user
Route::post('/tasks/{id}/assign', [TaskController::class, 'assign_task_to_user']);

//======================tasks
Route::get('tasks', [TaskController::class, 'index'])->middleware('role:admin,manager');
Route::get('tasks/{id}', [TaskController::class, 'show'])->middleware('role:admin,manager,employee');
Route::post('tasks', [TaskController::class, 'store'])->middleware('role:admin,manager');
Route::put('update-task/{id}', [TaskController::class, 'update'])->middleware(['auth:api', 'role:admin,manager,employee']);
Route::delete('tasks/{id}', [TaskController::class, 'softDelete'])->middleware('role:admin,manager');
Route::post('tasks/{id}/restore', [TaskController::class, 'restore'])->middleware('role:admin,manager');
Route::delete('tasks/{id}/force', [TaskController::class, 'forceDelete'])->middleware('role:admin,manager');
