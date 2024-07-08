<?php


use App\Http\Controllers\AppUser\AppUsersController;


use App\Http\Controllers\AppUser\AuthController;
use App\Http\Controllers\AppUser\HomeController;
use App\Http\Controllers\AppUser\ReviewController;

use App\Http\Controllers\AppUser\UserProfileController;



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

});
/////home page web

Route::post('/contact-us', [App\Http\Controllers\HomeController::class, 'contactUs']);
Route::get('/home-settings', [App\Http\Controllers\HomeController::class, 'Settings']);
require __DIR__ . '/dashboard.php';
