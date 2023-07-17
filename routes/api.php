<?php

use App\Http\Controllers\Api\SessionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::apiResource('/posts', App\Http\Controllers\Api\PostController::class);
Route::apiResource('/tests', App\Http\Controllers\Api\TestController::class);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::controller(SessionController::class)
    ->prefix('session')
    ->group(function () {

        Route::post('/get_access_token', 'get_access_token');
        Route::get('/logout', 'logout');

        Route::middleware('auth:api')->group(function () {
            Route::get('/login_as', 'login_as');
        });
    });

Route::controller(SessionController::class)
    ->prefix('login')
    ->group(function () {

        Route::post('/get_access_token', 'get_access_token');
        Route::get('/logout', 'logout');

        Route::middleware('auth:api')->group(function () {
            Route::get('/login_as', 'login_as');
        });
    });
