<?php

use App\Http\Controllers\Api\PostCommentController as ApiPostCommentController;
use App\Http\Controllers\Api\PostController as ApiPostController;
use App\Http\Controllers\Api\SessionController as ApiSessionController;
use App\Http\Controllers\Api\TestController as ApiTestController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;
use App\Http\Middleware\SessionOrJWTAuth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [HomeController::class, 'index'])->middleware('auth')->name('home');
Route::get('/home', [HomeController::class, 'index'])->middleware('auth');

Route::get('/login', [LoginController::class, 'index'], 'login')->middleware('guest')->name('login');
Route::post('/login/check', [LoginController::class, 'check'])->middleware('guest');

Route::get('/logout', [LogoutController::class, 'index'])->middleware('auth')->name('logout');
Route::resource('/photo', PostController::class)->middleware('auth');




// === API ===
Route::apiResource('/tests', ApiTestController::class);

Route::controller(ApiSessionController::class)
    ->prefix('api/session')
    ->group(function () {

        Route::post('/get_access_token', 'get_access_token');
        Route::get('/logout', 'logout');

        Route::middleware(SessionOrJWTAuth::class)->group(function () {
            Route::get('/login_as', 'login_as');
        });
    });

Route::controller(ApiSessionController::class)
    ->prefix('api/login')
    ->group(function () {

        Route::post('/get_access_token', 'get_access_token');
        Route::get('/logout', 'logout');

        Route::middleware(SessionOrJWTAuth::class)->group(function () {
            Route::get('/login_as', 'login_as');
        });
    });

Route::controller(ApiPostController::class)
    ->prefix('api/photo_mobile')
    ->group(function () {
        Route::middleware(SessionOrJWTAuth::class)->group(function () {
            Route::post('/insert', 'store');
            Route::get('/read', 'read');
            Route::get('/read_one', 'read_one');
            Route::post('/delete', 'delete');
        });
    });

Route::controller(ApiPostCommentController::class)
    ->prefix('api/photo_mobile_comment')
    ->group(function () {
        Route::middleware(SessionOrJWTAuth::class)->group(function () {
            Route::post('/insert', 'insert');
            Route::get('/read', 'read');
        });
    });
