<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClientsController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\ProjectsController;
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

Route::controller(CompanyController::class)->prefix('companies/')->group(function() {
    Route::get('{id}', 'show');
});

Route::controller( ClientsController::class)->prefix('clients/')->group(function () {
    Route::post('create', 'create');
    Route::get('', 'listAll');
});

Route::controller(ProjectsController::class)->prefix('projects/')->group(function() {
    Route::get('', 'listAll');
    Route::post('create', 'create');
    Route::get('{id}', 'find');
});
