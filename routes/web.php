<?php

use App\Http\Controllers\AccountController;
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
// frontend template 
// https://htmlcodex.com/job-portal-website-template/
// admin panel
// https://sneat-vuetify-admin-template.vercel.app/dashboard
// 

Route::group(['middleware' => "isGuest"], function () {
    Route::get('/login',  [AccountController::class, "login"])->name('login');
    Route::get('/register', [AccountController::class, "register"])->name('register');
    Route::post('/login', [AccountController::class, "doLogin"])->name('doLogin');
    Route::post('/register', [AccountController::class, "doRegister"])->name('doRegister');
    Route::group(['prefix' => "admin"], function () {
        Route::get('/', function () {
            echo "Admin";
        });
    });
});

Route::group(['middleware' => "isAuth"], function () {
    Route::get('/logout', [AccountController::class, "logout"])->name('logout');
    Route::get('/', [AccountController::class, "dashboard"])->name('dashboard');
    Route::get('/account', [AccountController::class, "account"])->name('account');
});
