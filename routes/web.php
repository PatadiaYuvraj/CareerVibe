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
    });
});

Route::group(['middleware' => "isAuth"], function () {
    Route::get('/', function () {
        echo "Admin";
    });

    Route::get('/logout', [AccountController::class, "logout"])->name('logout');
    Route::get('/', [AccountController::class, "dashboard"])->name('dashboard');
    Route::get('/account', [AccountController::class, "account"])->name('account');
    Route::get('/post-job', [AccountController::class, "post_job"])->name('post-job');
    Route::get('/job-applied', [AccountController::class, "job_applied"])->name('job-applied');
    Route::get('/saved-jobs', [AccountController::class, "saved_jobs"])->name('saved-jobs');
    Route::get('/my-jobs', [AccountController::class, "my_jobs"])->name('my-jobs');
    Route::get('/job-detail', [AccountController::class, "job_detail"])->name('job-detail');
    Route::get('/jobs', [AccountController::class, "jobs"])->name('jobs');
});
