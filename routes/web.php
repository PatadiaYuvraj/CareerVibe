<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CompanyController;
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
    Route::get('/test',  [UserController::class, "test"])->name('test');
    Route::post('/testing',  [UserController::class, "testing"])->name('testing');
    Route::get('/login',  [UserController::class, "login"])->name('login');
    Route::get('/register', [UserController::class, "register"])->name('register');
    Route::post('/login', [UserController::class, "doLogin"])->name('doLogin');
    Route::post('/register', [UserController::class, "doRegister"])->name('doRegister');


    // Admin Routes 
    Route::prefix('/admin')->group(function () {
        Route::get('/login',  [AdminController::class, "login"])->name('admin.login');
        Route::get('/register', [AdminController::class, "register"])->name('admin.register');
        Route::post('/login', [AdminController::class, "doLogin"])->name('admin.doLogin');
        Route::post('/register', [AdminController::class, "doRegister"])->name('admin.doRegister');
    });
});



Route::group(['middleware' => "isUser"], function () {
    Route::get("/logout", [UserController::class, 'logout'])->name('logout');
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

Route::group(['middleware' => "isAdmin"], function () {
    Route::prefix('/admin')->group(function () {
        Route::get('/logout',  [AdminController::class, "logout"])->name('admin.logout');
        Route::get('/dashboard',  [AdminController::class, "dashboard"])->name('admin.dashboard');
        Route::get('/getCompanies',  [CompanyController::class, "index"])->name('admin.getCompanies');
        Route::get('/getUsers',  [UserController::class, "index"])->name('admin.getUsers');
        Route::get('/getJobs',  [UserController::class, "index"])->name('admin.getJobs');
        Route::get('/getLocations',  [AdminController::class, "index"])->name('admin.getLocations');
        Route::get('/getQualifications',  [AdminController::class, "index"])->name('admin.getQualifications');
    });
});
