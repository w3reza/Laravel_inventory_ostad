<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\UserController;
use App\Http\Controllers\Backend\ProductController;
use App\Http\Controllers\Backend\CategoryController;

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
Route::get('/logout',[UserController::class,'UserLogout'])->middleware('auth:sanctum')->name('user.logout');
Route::post('/user_profile_update', [UserController::class, 'UserProfileUpdate'])->name('user.profile.update')->middleware('auth:sanctum');
Route::post('/SendOTP', [UserController::class, 'SendOTP'])->name('user.send.otp');
Route::post('/VerifyOTP', [UserController::class, 'VerifyOTP'])->name('user.verify.otp');
Route::post('/ResetPassword', [UserController::class, 'ResetPassword'])->name('user.update.password')->middleware('auth:sanctum');

Route::get('/category_list',[CategoryController::class,'index'])->name('category.index')->middleware('auth:sanctum');
Route::post('/category_store',[CategoryController::class,'store'])->name('category.store')->middleware('auth:sanctum');
Route::post('/category_update',[CategoryController::class,'update'])->name('category.update')->middleware('auth:sanctum');

Route::get('/product_list',[ProductController::class,'index'])->name('product.index')->middleware('auth:sanctum');
Route::post('/product_store',[ProductController::class,'store'])->name('product.store')->middleware('auth:sanctum');
Route::post('/product_update',[ProductController::class,'update'])->name('product.update')->middleware('auth:sanctum');


/*
|--------------------------------------------------------------------------
| Web Routes view Routes
|--------------------------------------------------------------------------
*/


Route::view('/registration', 'backend.pages.auth.registration_page')->name('registration');
Route::view('/login', 'backend.pages.auth.login_page')->name('login');
Route::view('/send_otp','backend.pages.auth.send_otp_page')->name('send.otp');
Route::view('/verify_otp','backend.pages.auth.verify_otp_page')->name('verify.otp');
Route::view('/reset_password','backend.pages.auth.reset_pass_page')->name('update.password');

Route::view('/userProfile', 'backend.pages.dashboard.profile_page')->name('backend.index');
Route::view('/catagory', 'backend.pages.dashboard.profile_page')->name('backend.index');


