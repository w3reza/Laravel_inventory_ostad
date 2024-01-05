<?php

use App\Http\Controllers\Backend\UserController;
use Illuminate\Support\Facades\Route;

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


/*
|--------------------------------------------------------------------------
| Web Routes API Routes
|--------------------------------------------------------------------------
*/

Route::post('/user_registration', [UserController::class, 'Registration'])->name('user.registration');
Route::post('/user_login', [UserController::class, 'UserLogin'])->name('user.login');
Route::get('/user_profile', [UserController::class, 'UserProfile'])->name('user.profile')->middleware('auth:sanctum');
Route::get('/logout',[UserController::class,'UserLogout'])->middleware('auth:sanctum');
Route::post('/user_profile_update', [UserController::class, 'UserProfileUpdate'])->name('user.profile.update')->middleware('auth:sanctum');
Route::post('/send_otp', [UserController::class, 'SendOTP'])->name('user.send.otp');
Route::post('/verify_otp', [UserController::class, 'VerifyOTP'])->name('user.verify.otp');


/*
|--------------------------------------------------------------------------
| Web Routes view Routes
|--------------------------------------------------------------------------
*/

Route::view('/userProfile', 'backend.pages.dashboard.profile_page')->name('backend.index');
Route::view('/registration', 'backend.pages.auth.registration_page')->name('registration');
Route::view('/login', 'backend.pages.auth.login_page')->name('login');

