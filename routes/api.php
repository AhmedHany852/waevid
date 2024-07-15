<?php

use App\Models\Order;
use Illuminate\Http\Request;


use App\Models\OrderServiceGame;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ReviewController;

use App\Http\Controllers\AppUser\AuthController;
use App\Http\Controllers\AppUser\OrderController;
use App\Http\Controllers\AppUser\AppUsersController;
use App\Http\Controllers\AppUser\AccountTypeController;
use App\Http\Controllers\AppUser\UserProfileController;
use App\Http\Controllers\AppUser\OrderServiceGameController;


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
Route::group([
    'prefix' => 'app_user/auth'
], function ($router) {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/check_number', [AppUsersController::class, 'check_number']);
    Route::post('/check_opt', [AppUsersController::class, 'check_opt']);
    Route::post('/register', [AuthController::class, 'register']);
});

Route::group([
    'middleware' => 'auth:app_users',

], function ($router) {
//reviews route
Route::post('/review', [ReviewController::class, 'store']);
Route::post('/review/{review}', [ReviewController::class, 'update']);
Route::delete('/review/{review}', [ReviewController::class, 'destroy']);
Route::get('/review/{id}', [ReviewController::class, 'show']);

///user profile
Route::get('/user-profile', [UserProfileController::class, 'index']);
Route::post('/update-profile', [UserProfileController::class, 'updateProfile']);
Route::get('/deactive-account', [UserProfileController::class, 'deactive_account']);
/////
Route::post('/booked-social-media', [OrderController::class, 'store']);
Route::post('/booked', [OrderServiceGameController::class, 'store']);
////account type
Route::get('/accounts', [AccountTypeController::class, 'index']);
Route::post('/accounts', [AccountTypeController::class, 'store']);
});
/////home page web
Route::get('/paylink-result', [OrderController::class, 'paylinkResult'])->name('paylink-result');
Route::get('/paylink-result2', [OrderServiceGameController::class, 'paylinkResult2'])->name('paylink-result2');

Route::post('/contact-us', [App\Http\Controllers\HomeController::class, 'contactUs']);
Route::get('/home-settings', [App\Http\Controllers\HomeController::class, 'Settings']);
require __DIR__ . '/dashboard.php';
