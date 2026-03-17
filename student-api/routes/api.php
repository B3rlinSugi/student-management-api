<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\StudentController;
use App\Http\Controllers\Api\MajorController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes — Student Management System
|--------------------------------------------------------------------------
|
| Auth    : POST /api/auth/register | login | logout | refresh | me
| Students: GET/POST/PUT/DELETE /api/students
| Majors  : GET/POST/PUT/DELETE /api/majors
|
*/

// ── Public routes ──
Route::prefix('auth')->group(function () {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login',    [AuthController::class, 'login']);
});

// ── Authenticated routes ──
Route::middleware('auth:api')->group(function () {

    // Auth
    Route::prefix('auth')->group(function () {
        Route::get('me',       [AuthController::class, 'me']);
        Route::post('refresh', [AuthController::class, 'refresh']);
        Route::post('logout',  [AuthController::class, 'logout']);
    });

    // Majors — read: all authenticated | write: admin only
    Route::get('majors',       [MajorController::class, 'index']);
    Route::get('majors/{major}', [MajorController::class, 'show']);
    Route::middleware('admin')->group(function () {
        Route::post('majors',          [MajorController::class, 'store']);
        Route::put('majors/{major}',   [MajorController::class, 'update']);
        Route::delete('majors/{major}',[MajorController::class, 'destroy']);
    });

    // Students — read: all authenticated | write/delete: admin only
    Route::get('students',         [StudentController::class, 'index']);
    Route::get('students/{student}', [StudentController::class, 'show']);
    Route::middleware('admin')->group(function () {
        Route::post('students',                    [StudentController::class, 'store']);
        Route::put('students/{student}',           [StudentController::class, 'update']);
        Route::delete('students/{student}',        [StudentController::class, 'destroy']);

        // Soft delete management
        Route::get('students/trashed/list',        [StudentController::class, 'trashed']);
        Route::post('students/{id}/restore',       [StudentController::class, 'restore']);
        Route::delete('students/{id}/force',       [StudentController::class, 'forceDelete']);
    });
});
