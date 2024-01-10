<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\UserController;
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
    // Route::group(['prefix' => "admin"], function () {
    // Route::get('/', function () {
    // echo "Admin";
    // });
    // });
});

Route::group(['middleware' => ["isAuth", "isUser"]], function () {
    Route::get("/logout", [AccountController::class, 'logout'])->name('logout');
    Route::get('/about', [UserController::class, "about"])->name('about');
    Route::get('/blog-single', [UserController::class, "blog_single"])->name('blog-single');
    Route::get('/blog', [UserController::class, "blog"])->name('blog');
    Route::get('/contact', [UserController::class, "contact"])->name('contact');
    Route::get('/faq', [UserController::class, "faq"])->name('faq');
    Route::get('/gallery', [UserController::class, "gallery"])->name('gallery');
    Route::get('/', [UserController::class, "index"])->name('index');
    Route::get('/job-listings', [UserController::class, "job_listings"])->name('job-listings');
    Route::get('/job-single', [UserController::class, "job_single"])->name('job-single');
    Route::get('/portfolio-single', [UserController::class, "portfolio_single"])->name('portfolio-single');
    Route::get('/portfolio', [UserController::class, "portfolio"])->name('portfolio');
    Route::get('/post-job', [UserController::class, "post_job"])->name('post-job');
    Route::get('/service-sinlge', [UserController::class, "service_sinlge"])->name('service-sinlge');
    Route::get('/services', [UserController::class, "services"])->name('services');
    Route::get('/testimonials', [UserController::class, "testimonials"])->name('testimonials');
});
