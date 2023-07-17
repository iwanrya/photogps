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
    ->as('session')
    ->group(function () {

        Route::post('/get_access_token', 'get_access_token');

        Route::middleware('auth:sanctum')->group(function () {
            Route::post('/login_as', 'login_as');
            Route::post('/logout', 'logout');
        });
    });
