<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\UserController;
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

Route::post('/UserRegistration', [UserController::class, 'UserRegistration'])->name('user.registration');
Route::post('/UserLogin', [UserController::class, 'UserLogin'])->name('user.login');
Route::post('/SendOTP', [UserController::class, 'SendOTPCode'])->name('user.send.otp');
Route::post('/VerifyOTP', [UserController::class, 'VerifyOTP'])->name('user.verify.otp');
Route::post('/ResetPassword', [UserController::class, 'ResetPassword'])->name('user.update.password')->middleware('auth:sanctum');
Route::get('/UserProfile', [UserController::class, 'UserProfile'])->name('user.profile')->middleware('auth:sanctum');
Route::post('/UpdateProfile', [UserController::class, 'UpdateProfile'])->name('user.profile.update')->middleware('auth:sanctum');
Route::get('/logout',[UserController::class,'UserLogout'])->middleware('auth:sanctum');

/*
|--------------------------------------------------------------------------
| Web Routes view Routes
|--------------------------------------------------------------------------
*/


Route::view('/', 'backend.pages.auth.login_page')->name('login');
Route::view('/userProfile', 'backend.pages.dashboard.profile_page')->name('backend.index');
Route::view('/registration', 'backend.pages.auth.registration_page')->name('registration');
Route::view('/login', 'backend.pages.auth.login_page')->name('login');
Route::view('/send_otp','backend.pages.auth.send_otp_page')->name('send.otp');
Route::view('/verify_otp','backend.pages.auth.verify_otp_page')->name('verify.otp');
Route::view('/reset_password','backend.pages.auth.reset_pass_page')->name('update.password');

/*
|--------------------------------------------------------------------------
| Category Web API Routes
|--------------------------------------------------------------------------
*/

Route::post('/CategoryCreate', [CategoryController::class, 'CategoryCreate'])->name('category.add')->middleware('auth:sanctum');
Route::get('/CategoryList', [CategoryController::class, 'CategoryList'])->name('category.list')->middleware('auth:sanctum');
Route::post('/CategoryByID', [CategoryController::class, 'CategoryByID'])->name('category.by.id')->middleware('auth:sanctum');
Route::post('/CategoryUpdate', [CategoryController::class, 'CategoryUpdate'])->name('category.update')->middleware('auth:sanctum');
Route::post('/CategoryDelete', [CategoryController::class, 'CategoryDelete'])->name('category.delete')->middleware('auth:sanctum');





/*
|--------------------------------------------------------------------------
| Web Routes view Routes
|--------------------------------------------------------------------------
*/

Route::view('/category_list', 'backend.pages.dashboard.category_page')->name('category.list');

