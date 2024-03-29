<?php

use App\Http\Controllers\Api\AreaController as ApiAreaController;
use App\Http\Controllers\Api\CustomerController as ApiCustomerController;
use App\Http\Controllers\Api\PhotographerController;
use App\Http\Controllers\Api\PostCommentController as ApiPostCommentController;
use App\Http\Controllers\Api\PostController as ApiPostController;
use App\Http\Controllers\Api\ProjectController as ApiProjectController;
use App\Http\Controllers\Api\SessionController as ApiSessionController;
use App\Http\Controllers\Api\StatusController as ApiStatusController;
use App\Http\Controllers\Api\TestController as ApiTestController;
use App\Http\Controllers\Api\ChangePasswordController as ApiChangePasswordController;
use App\Http\Controllers\AreaController;
use App\Http\Controllers\ChangePasswordController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\CustomerController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\MapController;
use App\Http\Controllers\PostPhotoController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\UserAuthController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\SessionOrJWTAuth;
use Illuminate\Support\Facades\Auth;

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
Route::get('/maps', [MapController::class, 'index']);

Route::get('/login', [LoginController::class, 'index'], 'login')->middleware('guest')->name('login');
Route::post('/login/check', [LoginController::class, 'check'])->middleware('guest');

Route::get('/changepassword', [ChangePasswordController::class, 'index'], 'changepassword')->middleware('auth')->name('changepassword');
Route::post('/changepassword/change', [ChangePasswordController::class, 'change'])->middleware('auth');

Route::get('/logout', [LogoutController::class, 'index'])->middleware('auth')->name('logout');

Route::middleware(SessionOrJWTAuth::class)->group(function () {
    Route::get('/photo', [PostController::class, 'index']);
    Route::get('/photo/original_image/{id}', [PostController::class, 'original_image']);
    Route::get('/photo/original_images/{id}', [PostController::class, 'original_images']);
});
Route::get('/photo/images/{id}', [PostController::class, 'images']);
Route::get('/post_photo/resize/{id}/{maxDim}', [PostPhotoController::class, 'resize']);

Route::middleware(SessionOrJWTAuth::class)->group(function () {
    Route::get('/post_photo/original_image/{id}', [PostPhotoController::class, 'original_image']);
});

Route::get('/post/report/{id}', [PostController::class, 'report'])->name('post.report');

Route::middleware('auth')->group(function () {

    Route::middleware('system_owner')->group(function () {

        Route::resources([
            'area' => AreaController::class,
            // 'customer' => CustomerController::class,
            'project' => ProjectController::class,
            'user' => UserController::class,
            'user_auth' => UserAuthController::class,
            'company' => CompanyController::class,
        ]);

        Route::get('/project/delete/{id}', [ProjectController::class, 'delete'])->name('project.delete');
        Route::get('/user/delete/{id}', [UserController::class, 'delete'])->name('user.delete');
    });
});


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

Route::controller(ApiChangePasswordController::class)
    ->prefix('api/changepassword')
    ->group(function () {

        Route::middleware(SessionOrJWTAuth::class)->group(function () {
            Route::post('/change', 'change');
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


Route::controller(ApiCustomerController::class)
    ->prefix('api/customer')
    ->group(function () {
        Route::middleware(SessionOrJWTAuth::class)->group(function () {
            Route::get('/dropdown', 'dropdown');
        });
    });

Route::controller(ApiProjectController::class)
    ->prefix('api/project')
    ->group(function () {
        Route::middleware(SessionOrJWTAuth::class)->group(function () {
            Route::get('/dropdown', 'dropdown');
        });
    });

Route::controller(ApiStatusController::class)
    ->prefix('api/status')
    ->group(function () {
        Route::middleware(SessionOrJWTAuth::class)->group(function () {
            Route::get('/dropdown', 'dropdown');
        });
    });

Route::controller(PhotographerController::class)
    ->prefix('api/photographer')
    ->group(function () {
        Route::middleware(SessionOrJWTAuth::class)->group(function () {
            Route::get('/dropdown', 'dropdown');
        });
    });

Route::controller(ApiAreaController::class)
    ->prefix('api/area')
    ->group(function () {
        Route::middleware(SessionOrJWTAuth::class)->group(function () {
            Route::get('/dropdown', 'dropdown');
        });
    });
