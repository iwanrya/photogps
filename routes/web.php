<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;

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