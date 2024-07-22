<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\AuthController;

use App\Http\Controllers\Admin\GameController;
use App\Http\Controllers\Admin\RoleController;


use App\Http\Controllers\Admin\UserController;

use App\Http\Controllers\Admin\TermsController;
use App\Http\Controllers\Admin\ReviewController;
use App\Http\Controllers\Admin\AboutUsController;

use App\Http\Controllers\Admin\CouponsController;
use App\Http\Controllers\Admin\ReportsController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\SettingController;

use App\Http\Controllers\Admin\ContacUsController;
use App\Http\Controllers\AppUser\GeneralController;
use App\Http\Controllers\Admin\SocialMediaController;





Route::group([
    'prefix' => 'auth'
], function ($router) {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
});
Route::group([
    'middleware' => 'auth:users',
    'prefix' => 'dashboard',
], function ($router) {
    //users
    Route::get('/me', [UserController::class, 'me']);
    Route::get('/users', [UserController::class, 'index']);
    Route::get('/users/{user}', [UserController::class, 'show']);
    Route::post('/users', [UserController::class, 'store']);
    Route::post('/users/{user}', [UserController::class, 'update']);
    Route::delete('/users/{user}', [UserController::class, 'destroy']);
    Route::get('getUserCount', [UserController::class, 'getUserCount']);
    //roles
    Route::get('/roles', [RoleController::class, 'index']);
    Route::get('/roles/{role}', [RoleController::class, 'show']);
    Route::post('/roles', [RoleController::class, 'store']);
    Route::post('/roles/{role}', [RoleController::class, 'update']);
    Route::delete('/roles/{role}', [RoleController::class, 'destroy']);


    /////////about_us
    Route::get('/about_us', [AboutUsController::class, 'index']);
    Route::get('/about_us/{about_us}', [AboutUsController::class, 'show']);
    Route::post('/about_us', [AboutUsController::class, 'store']);
    Route::post('/about_us/{about_us}', [AboutUsController::class, 'update']);
    Route::delete('/about_us/{about_us}', [AboutUsController::class, 'destroy']);

    /////////terms
    Route::get('/terms', [TermsController::class, 'index']);
    Route::get('/terms/{term}', [TermsController::class, 'show']);
    Route::post('/terms', [TermsController::class, 'store']);
    Route::post('/terms/{term}', [TermsController::class, 'update']);
    Route::delete('/terms/{term}', [TermsController::class, 'destroy']);


    //setting
    Route::get('/setting', [SettingController::class, 'index']);
    Route::post('/setting', [SettingController::class, 'store']);

    ///contact us
    Route::get('/contact-us', [ContacUsController::class, 'index']);
    Route::get('/count-contacts', [ContacUsController::class, 'count_contacts']);
    //
    Route::get('/app-users', [UserController::class, 'All']);
    Route::get('/count-appUsers', [UserController::class, 'count_appUsers']);
    //services
    Route::get('/services', [ServiceController::class, 'index']);
    Route::get('/services/{service}', [ServiceController::class, 'show']);
    Route::post('/services', [ServiceController::class, 'store']);
    Route::post('/services/{service}', [ServiceController::class, 'update']);
    Route::delete('/services/{service}', [ServiceController::class, 'destroy']);
    Route::get('getServicesCount', [ServiceController::class, 'getServiceCount']);

    //games
    Route::get('/games', [GameController::class, 'index']);
    Route::get('/games/{game}', [GameController::class, 'show']);
    Route::post('/games', [GameController::class, 'store']);
    Route::post('/games/{game}', [GameController::class, 'update']);
    Route::delete('/games/{game}', [GameController::class, 'destroy']);
    Route::get('getGameCount', [GameController::class, 'getGameCount']);

    //reviews
    Route::get('/reviews', [ReviewController::class, 'index']);
    Route::get('/reviews/{id}', [ReviewController::class, 'show']);
    Route::delete('/reviews/{id}', [ReviewController::class, 'destroy']);


    Route::get('/coupons', [CouponsController::class, 'index']);
    Route::post('/coupons', [CouponsController::class, 'store']);
    Route::get('/coupons/{coupon}', [CouponsController::class, 'show']);
    Route::post('/coupons/{coupon}', [CouponsController::class, 'update']);
    Route::delete('/coupons/{coupon}', [CouponsController::class, 'destroy']);

    //  Social Media
    Route::get('/social-media', [SocialMediaController::class, 'index']);
    Route::post('/social-media', [SocialMediaController::class, 'store']);
    Route::get('/social-media/{id}', [SocialMediaController::class, 'show']);
    Route::post('/social-media/{id}', [SocialMediaController::class, 'update']);
    Route::delete('/social-media/{id}', [SocialMediaController::class, 'destroy']);
    Route::get('getSocialCount', [SocialMediaController::class, 'SocialCount']);
    //reports
    Route::get('/all-order', [ReportsController::class, 'all_orders']);
    Route::get('/all-orders-service', [ReportsController::class, 'all_orders_service']);
    Route::get('/all-orders-game', [ReportsController::class, 'all_orders_games']);
    Route::get('/all-payments', [ReportsController::class, 'all_payments']);
    //////
    Route::get('/social-most-common', [GeneralController::class, 'getSocialMostCommon']);
    Route::get('/service-most-common', [GeneralController::class, 'getServiceMostCommon']);
    Route::get('/game-most-common', [GeneralController::class, 'getGameMostCommon']);
    //
    Route::get('/all-accounts', [GeneralController::class, 'getAllAccounts']);


});
