<?php

use App\Http\Controllers\CoreContext\AuthController;
use App\Http\Controllers\CoreContext\CompanyController;
use App\Http\Controllers\CoreContext\RoleController;
use App\Http\Controllers\CoreContext\UsersController;
use App\Http\Controllers\TimeTrackingContext\CheckController;
use App\Http\Controllers\TimeTrackingContext\ClientsController;
use App\Http\Controllers\TimeTrackingContext\ProjectsController;
use App\Http\Controllers\TimeTrackingContext\TasksController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::controller(AuthController::class)->group(function () {
    Route::post('login', 'login');
    Route::post('register', 'register');
    Route::post('logout', 'logout');
    Route::post('refresh', 'refresh');
});

Route::middleware('jwt.verify')->group(function() {
    Route::controller(CompanyController::class)->prefix('companies/')->group(function() {
        Route::get('', 'index');
        Route::get('{id}', 'show');
        Route::delete('{id}', 'delete');
        Route::post('{id}', 'update');
    });

    Route::controller(UsersController::class)->prefix('users/')->group(function() {
        Route::get('', 'listAll');
        Route::get('{id}', 'find');
        Route::delete('{id}', 'delete');
        Route::post('{id}', 'update');
    });

    Route::controller( ClientsController::class)->prefix('clients/')->group(function () {
        Route::post('', 'create');
        Route::get('', 'listAll');
        Route::get('{id}', 'find');
        Route::delete('{id}', 'delete');
        Route::post('{id}', 'update');
    });

    Route::controller(ProjectsController::class)->prefix('projects/')->group(function() {
        Route::get('', 'listAll');
        Route::post('', 'create');
        Route::get('{id}', 'find');
        Route::delete('{id}', 'delete');
        Route::post('{id}', 'update');
    });

    Route::controller(TasksController::class)->prefix('tasks/')->group(function() {
        Route::post('', 'create');
        Route::get('', 'index');
        Route::post('{id}', 'update');
        Route::get('{id}', 'show');
        Route::delete('{id}', 'delete');
    });

    Route::controller(CheckController::class)->prefix('checks/')->group(function() {
        Route::post('', 'create');
        Route::post('check-in', 'checkIn');
        Route::post('check-out', 'checkOut');
        Route::get('', 'index');
        Route::post('/user-calendar/{userId}', 'getCalendarForUser');
        Route::post('/team-calendar', 'getCalendarForTeam');
        Route::get('{id}', 'show');
        Route::post('{id}', 'update');
        Route::delete('{id}', 'delete');
    });

    Route::controller(RoleController::class)->prefix('roles/')->group(function() {
        Route::post('', 'create');
        Route::get('', 'index');
    });
});
