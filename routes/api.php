<?php

use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\Department\DepartmentController;
use App\Http\Controllers\Api\Permission\PermissionController;
use App\Http\Controllers\Api\Role\RoleController;
use App\Http\Controllers\Api\User\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('login',[AuthController::class,'login']);



Route::prefix('users')->group(function () {
    Route::get('/',[UserController::class,'index']);
    Route::get('/create',[UserController::class,'create']);
    Route::get('/{id}/edit',[UserController::class,'edit']);
    Route::get('/{id}',[UserController::class,'show']);
    Route::post('/',[UserController::class,'store'])->name('users.store');
    Route::put('/{id}',[UserController::class,'update'])->name('users.update');
    Route::delete('/{id}',[UserController::class,'destroy'])->name('users.destroy');
    Route::put('/{id}/reset-password', [UserController::class, 'resetPassword'])->name('users.password.reset');
    Route::get('/{id}/login-history', [UserController::class, 'loginHistory'])->name('users.login.history');
    Route::put('/{id}/activate', [UserController::class, 'activate'])->name('users.activate');
    Route::post('/{id}/assign-role', [UserController::class, 'assignRole'])->name('users.assign.role');
    Route::post('/{id}/assign-permission', [UserController::class, 'assignPermission'])->name('users.assign.permission');
    Route::post('/{id}/notify', [UserController::class, 'notifyUser'])->name('users.notify');
});

Route::prefix('departments')->group(function () {
    Route::get('/',[DepartmentController::class,'index']);
    Route::get('/create',[DepartmentController::class,'create']);
    Route::get('/{id}/edit',[DepartmentController::class,'edit']);
    Route::get('/{id}',[DepartmentController::class,'show']);
    Route::post('/',[DepartmentController::class,'store'])->name('departments.store');
    Route::put('/{id}',[DepartmentController::class,'update'])->name('departments.update');
    Route::delete('/{id}',[DepartmentController::class,'destroy'])->name('departments.destroy');
    // Route::put('/{id}/reset-password', [UserController::class, 'resetPassword'])->name('departments.password.reset');
    // Route::get('/{id}/login-history', [UserController::class, 'loginHistory'])->name('departments.login.history');
    // Route::put('/{id}/activate', [UserController::class, 'activate'])->name('departments.activate');
    // Route::post('/{id}/assign-role', [UserController::class, 'assignRole'])->name('departments.assign.role');
    // Route::post('/{id}/assign-permission', [UserController::class, 'assignPermission'])->name('departments.assign.permission');
    // Route::post('/{id}/notify', [UserController::class, 'notifyUser'])->name('departments.notify');
});
// Route::get('users',[UserController::class,'index']);
// Route::get('users/create',[UserController::class,'create']);
// Route::get('users/{id}/edit',[UserController::class,'edit']);
// Route::get('users/{id}',[UserController::class,'show']);
// Route::post('users',[UserController::class,'store'])->name('users.store');
// Route::put('users/{id}',[UserController::class,'update'])->name('users.update');
// Route::delete('users/{id}',[UserController::class,'destroy'])->name('users.destroy');
// Route::put('users/{id}/reset-password', [UserController::class, 'resetPassword'])->name('users.password.reset');
// Route::get('users/{id}/login-history', [UserController::class, 'loginHistory'])->name('users.login.history');
// Route::put('users/{id}/activate', [UserController::class, 'activate'])->name('users.activate');
// Route::post('users/{id}/assign-role', [UserController::class, 'assignRole'])->name('users.assign.role');
// Route::post('users/{id}/assign-permission', [UserController::class, 'assignPermission'])->name('users.assign.permission');
// Route::post('users/{id}/notify', [UserController::class, 'notifyUser'])->name('users.notify');

Route::get('permissions',[PermissionController::class,'index']);
Route::get('permissions/create',[PermissionController::class,'create']);
Route::get('permissions/{id}/edit',[PermissionController::class,'edit']);
Route::get('permissions/{id}',[PermissionController::class,'show']);
Route::post('permissions',[PermissionController::class,'store'])->name('permissions.store');
Route::put('permissions/{id}',[PermissionController::class,'update'])->name('permissions.update');
Route::delete('permissions/{id}',[PermissionController::class,'destroy'])->name('permissions.destroy');


Route::get('roles',[RoleController::class,'index']);
Route::get('roles/create',[RoleController::class,'create']);
Route::get('roles/{id}/edit',[RoleController::class,'edit']);
Route::get('roles/{id}',[RoleController::class,'show']);
Route::post('roles',[RoleController::class,'store'])->name('roles.store');
Route::put('roles/{id}',[RoleController::class,'update'])->name('roles.update');
Route::delete('roles/{id}',[RoleController::class,'destroy'])->name('roles.destroy');