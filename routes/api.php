<?php

use App\Http\Controllers\AppUser\AccountTypeController;
use App\Http\Controllers\AppUser\AppUsersController;


use App\Http\Controllers\AppUser\AuthController;
use App\Http\Controllers\AppUser\GeneralController;
use App\Http\Controllers\AppUser\OrderController;

use App\Http\Controllers\AppUser\OrderServiceGameController;
use App\Http\Controllers\AppUser\BestSellController;
use App\Http\Controllers\AppUser\ReviewController;
use App\Http\Controllers\AppUser\UserProfileController;
use App\Models\Order;
use App\Models\OrderServiceGame;
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

Route::get('/paylink-result', [OrderController::class, 'paylinkResult'])->name('paylink-result');
Route::get('/paylink-result2', [OrderServiceGameController::class, 'paylinkResult2'])->name('paylink-result2');
////////general
Route::get('/social-media', [GeneralController::class, 'social_media']);
Route::get('/services', [GeneralController::class, 'services']);
Route::get('/games', [GeneralController::class, 'games']);
////
Route::get('/social-media/{id}', [GeneralController::class, 'showSocial']);
Route::get('/services/{service}', [GeneralController::class, 'showService']);
Route::get('/games/{game}', [GeneralController::class, 'showGame']);
/////home page web
Route::post('/contact-us', [App\Http\Controllers\HomeController::class, 'contactUs']);
Route::get('/home-settings', [App\Http\Controllers\HomeController::class, 'Settings']);

//best-sell
Route::get('/best-sell-social-media', [BestSellController::class, 'bestSellSocialMedia']);
Route::get('/best-sell-services', [BestSellController::class, 'bestSellServices']);
Route::get('/best-sell-games', [BestSellController::class, 'bestSellGames']);

require __DIR__ . '/dashboard.php';
