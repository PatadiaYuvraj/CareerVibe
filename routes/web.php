<?php


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

use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\CompanyController;
use App\Http\Controllers\Front\UserController as FrontUserController;
use App\Http\Controllers\Admin\JobController;
use App\Http\Controllers\Admin\LocationController;
use App\Http\Controllers\Admin\QualificationController;
use App\Http\Controllers\Admin\JobProfileController;
use App\Http\Controllers\TestController;
use Illuminate\Support\Facades\Route;

Route::get('/test',  [TestController::class, "test"])->name('test');
Route::post('/testing',  [TestController::class, "testing"])->name('testing');


Route::group(['middleware' => "isGuest"], function () {

    Route::get('/login',  [FrontUserController::class, "login"])->name('login');
    Route::get('/register', [FrontUserController::class, "register"])->name('register');
    Route::post('/login', [FrontUserController::class, "doLogin"])->name('doLogin');
    Route::post('/register', [FrontUserController::class, "doRegister"])->name('doRegister');


    // Admin Routes 
    Route::prefix('/admin')->group(function () {
        Route::get('/login',  [AdminController::class, "login"])->name('admin.login');
        Route::get('/register', [AdminController::class, "register"])->name('admin.register');
        Route::post('/login', [AdminController::class, "doLogin"])->name('admin.doLogin');
        Route::post('/register', [AdminController::class, "doRegister"])->name('admin.doRegister');
    });
});



Route::group(['middleware' => "isUser"], function () {
    Route::get('/', [FrontUserController::class, "index"])->name('index');
    Route::get("/logout", [FrontUserController::class, 'logout'])->name('logout');
    Route::get('/about', [FrontUserController::class, "about"])->name('about');
    Route::get('/blog-single', [FrontUserController::class, "blog_single"])->name('blog-single');
    Route::get('/blog', [FrontUserController::class, "blog"])->name('blog');
    Route::get('/contact', [FrontUserController::class, "contact"])->name('contact');
    Route::get('/faq', [FrontUserController::class, "faq"])->name('faq');
    Route::get('/gallery', [FrontUserController::class, "gallery"])->name('gallery');
    Route::get('/job-listings', [FrontUserController::class, "job_listings"])->name('job-listings');
    Route::get('/job-single', [FrontUserController::class, "job_single"])->name('job-single');
    Route::get('/portfolio-single', [FrontUserController::class, "portfolio_single"])->name('portfolio-single');
    Route::get('/portfolio', [FrontUserController::class, "portfolio"])->name('portfolio');
    Route::get('/post-job', [FrontUserController::class, "post_job"])->name('post-job');
    Route::get('/service-sinlge', [FrontUserController::class, "service_sinlge"])->name('service-sinlge');
    Route::get('/services', [FrontUserController::class, "services"])->name('services');
    Route::get('/testimonials', [FrontUserController::class, "testimonials"])->name('testimonials');
});

Route::group(['middleware' => "isAdmin"], function () {
    Route::prefix('/admin')->group(function () {
        // admin edit profile
        Route::get('/edit-profile',  [AdminController::class, "editProfile"])->name('admin.editProfile');
        Route::post('/update-profile',  [AdminController::class, "updateProfile"])->name('admin.updateProfile');
        Route::get('/change-password',  [AdminController::class, "changePassword"])->name('admin.changePassword');
        Route::post('/change-password',  [AdminController::class, "doChangePassword"])->name('admin.doChangePassword');
        // dashboard 
        Route::get('/dashboard',  [AdminController::class, "dashboard"])->name('admin.dashboard');
        // logout 
        Route::get('/logout',  [AdminController::class, "logout"])->name('admin.logout');
        // User Routes 
        Route::prefix('user')->group(function () {
            Route::get('/create',  [AdminUserController::class, "create"])->name('admin.user.create');
            Route::post('/store',  [AdminUserController::class, "store"])->name('admin.user.store');
            Route::get('/',  [AdminUserController::class, "index"])->name('admin.user.index');
            Route::get('/{id}',  [AdminUserController::class, "show"])->name('admin.user.show');
            Route::get('/edit/{id}',  [AdminUserController::class, "edit"])->name('admin.user.edit');
            Route::post('/update/{id}',  [AdminUserController::class, "update"])->name('admin.user.update');
            Route::get('/delete/{id}',  [AdminUserController::class, "delete"])->name('admin.user.delete');
        });
        // Company Routes 
        Route::prefix('company')->group(function () {
            Route::get('/create',  [CompanyController::class, "create"])->name('admin.company.create');
            Route::post('/store',  [CompanyController::class, "store"])->name('admin.company.store');
            Route::get('/',  [CompanyController::class, "index"])->name('admin.company.index');
            Route::get('/{id}',  [CompanyController::class, "show"])->name('admin.company.show');
            Route::get('/edit/{id}',  [CompanyController::class, "edit"])->name('admin.company.edit');
            Route::post('/update/{id}',  [CompanyController::class, "update"])->name('admin.company.update');
            Route::get('/delete/{id}',  [CompanyController::class, "delete"])->name('admin.company.delete');
            Route::get('/toggle-verified/{id}/{is_verified}',  [CompanyController::class, "toggleVerified"])->name('admin.company.toggleVerified');
        });
        // Job Routes 
        Route::prefix('job')->group(function () {
            Route::get('/create/{id}',  [JobController::class, "create"])->name('admin.job.create');
            Route::post('/store/{id}',  [JobController::class, "store"])->name('admin.job.store');
            Route::get('/',  [JobController::class, "index"])->name('admin.job.index');
            Route::get('/{id}',  [JobController::class, "show"])->name('admin.job.show');
            Route::get('/edit/{id}',  [JobController::class, "edit"])->name('admin.job.edit');
            Route::post('/update/{id}',  [JobController::class, "update"])->name('admin.job.update');
            Route::get('/delete/{id}',  [JobController::class, "delete"])->name('admin.job.delete');
            Route::get('/toggle-verified/{id}/{is_verified}',  [JobController::class, "toggleVerified"])->name('admin.job.toggleVerified');
            Route::get('/toggle-featured/{id}/{is_featured}',  [JobController::class, "toggleFeatured"])->name('admin.job.toggleFeatured');
            Route::get('/toggle-active/{id}/{is_active}',  [JobController::class, "toggleActive"])->name('admin.job.toggleActive');
        });
        // Job Profiles Routes 
        Route::prefix('/job-profile')->group(function () {
            Route::get('/create',  [JobProfileController::class, "create"])->name('admin.job-profile.create');
            Route::post('/store',  [JobProfileController::class, "store"])->name('admin.job-profile.store');
            Route::get('/',  [JobProfileController::class, "index"])->name('admin.job-profile.index');
            Route::get('/{id}',  [JobProfileController::class, "show"])->name('admin.job-profile.show');
            Route::get('/edit/{id}',  [JobProfileController::class, "edit"])->name('admin.job-profile.edit');
            Route::post('/update/{id}',  [JobProfileController::class, "update"])->name('admin.job-profile.update');
            Route::get('/delete/{id}',  [JobProfileController::class, "delete"])->name('admin.job-profile.delete');
        });
        // Location Routes 
        Route::prefix('location')->group(function () {
            Route::get('/create',  [LocationController::class, "create"])->name('admin.location.create');
            Route::post('/store',  [LocationController::class, "store"])->name('admin.location.store');
            Route::get('/',  [LocationController::class, "index"])->name('admin.location.index');
            Route::get('/{id}',  [LocationController::class, "show"])->name('admin.location.show');
            Route::get('/edit/{id}',  [LocationController::class, "edit"])->name('admin.location.edit');
            Route::post('/update/{id}',  [LocationController::class, "update"])->name('admin.location.update');
            Route::get('/delete/{id}',  [LocationController::class, "delete"])->name('admin.location.delete');
        });
        // Qualification Routes
        Route::prefix('qualification')->group(function () {
            Route::get('/create',  [QualificationController::class, "create"])->name('admin.qualification.create');
            Route::post('/store',  [QualificationController::class, "store"])->name('admin.qualification.store');
            Route::get('/',  [QualificationController::class, "index"])->name('admin.qualification.index');
            Route::get('/{id}',  [QualificationController::class, "show"])->name('admin.qualification.show');
            Route::get('/edit/{id}',  [QualificationController::class, "edit"])->name('admin.qualification.edit');
            Route::post('/update/{id}',  [QualificationController::class, "update"])->name('admin.qualification.update');
            Route::get('/delete/{id}',  [QualificationController::class, "delete"])->name('admin.qualification.delete');
        });
    });
});
