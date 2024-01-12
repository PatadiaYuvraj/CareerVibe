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
use App\Http\Controllers\Admin\ProfileController;
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
        // dashboard 
        Route::get('/dashboard',  [AdminController::class, "dashboard"])->name('admin.dashboard');
        // logout 
        Route::get('/logout',  [AdminController::class, "logout"])->name('admin.logout');
        // User Routes 
        Route::get('/user/create',  [AdminUserController::class, "create"])->name('admin.user.create');
        Route::post('/user/store',  [AdminUserController::class, "store"])->name('admin.user.store');
        Route::get('/user',  [AdminUserController::class, "index"])->name('admin.user.index');
        // Route::get('/user/{id}',  [AdminUserController::class, "show"])->name('admin.user.show');
        Route::get('/user/edit/{id}',  [AdminUserController::class, "edit"])->name('admin.user.edit');
        Route::post('/user/update/{id}',  [AdminUserController::class, "update"])->name('admin.user.update');
        Route::get('/user/delete/{id}',  [AdminUserController::class, "delete"])->name('admin.user.delete');
        // Company Routes 
        Route::get('/company/create',  [CompanyController::class, "create"])->name('admin.company.create');
        Route::post('/company/store',  [CompanyController::class, "store"])->name('admin.company.store');
        Route::get('/company',  [CompanyController::class, "index"])->name('admin.company.index');
        // Route::get('/company/{id}',  [CompanyController::class, "show"])->name('admin.company.show');
        Route::get('/company/edit/{id}',  [CompanyController::class, "edit"])->name('admin.company.edit');
        Route::post('/company/update/{id}',  [CompanyController::class, "update"])->name('admin.company.update');
        Route::get('/company/delete/{id}',  [CompanyController::class, "delete"])->name('admin.company.delete');
        Route::get('/company/toggle-verified/{id}/{is_verified}',  [CompanyController::class, "toggleVerified"])->name('admin.company.toggleVerified');
        // Job Routes 
        Route::get('/job/create',  [JobController::class, "create"])->name('admin.job.create');
        Route::post('/job/store',  [JobController::class, "store"])->name('admin.job.store');
        Route::get('/job',  [JobController::class, "index"])->name('admin.job.index');
        // Route::get('/job/{id}',  [JobController::class, "show"])->name('admin.job.show');
        Route::get('/job/edit/{id}',  [JobController::class, "edit"])->name('admin.job.edit');
        Route::post('/job/update/{id}',  [JobController::class, "update"])->name('admin.job.update');
        Route::get('/job/delete/{id}',  [JobController::class, "delete"])->name('admin.job.delete');
        Route::get('/job/toggle-verified/{id}/{is_verified}',  [JobController::class, "toggleVerified"])->name('admin.job.toggleVerified');
        Route::get('/job/toggle-featured/{id}/{is_featured}',  [JobController::class, "toggleFeatured"])->name('admin.job.toggleFeatured');
        Route::get('/job/toggle-active/{id}/{is_active}',  [JobController::class, "toggleActive"])->name('admin.job.toggleActive');
        // Location Routes // $isUpdated = $this->updateLocation($id, $data);
        Route::get('/location/create',  [LocationController::class, "create"])->name('admin.location.create');
        Route::post('/location/store',  [LocationController::class, "store"])->name('admin.location.store');
        Route::get('/location',  [LocationController::class, "index"])->name('admin.location.index');
        // Route::get('/location/{id}',  [LocationController::class, "show"])->name('admin.location.show');
        Route::get('/location/edit/{id}',  [LocationController::class, "edit"])->name('admin.location.edit');
        Route::post('/location/update/{id}',  [LocationController::class, "update"])->name('admin.location.update');
        Route::get('/location/delete/{id}',  [LocationController::class, "delete"])->name('admin.location.delete');
        // Qualification Routesuser
        Route::get('/qualification/create',  [QualificationController::class, "create"])->name('admin.qualification.create');
        Route::post('/qualification/store',  [QualificationController::class, "store"])->name('admin.qualification.store');
        Route::get('/qualification',  [QualificationController::class, "index"])->name('admin.qualification.index');
        // Route::get('/qualification/{id}',  [QualificationController::class, "show"])->name('admin.qualification.show');
        Route::get('/qualification/edit/{id}',  [QualificationController::class, "edit"])->name('admin.qualification.edit');
        Route::post('/qualification/update/{id}',  [QualificationController::class, "update"])->name('admin.qualification.update');
        Route::get('/qualification/delete/{id}',  [QualificationController::class, "delete"])->name('admin.qualification.delete');

        // Job Profiles Routes 
        Route::get('/job-profile/create',  [ProfileController::class, "create"])->name('admin.job-profile.create');
        Route::post('/job-profile/store',  [ProfileController::class, "store"])->name('admin.job-profile.store');
        Route::get('/job-profile',  [ProfileController::class, "index"])->name('admin.job-profile.index');
        // Route::get('/job-profile/{id}',  [ProfileController::class, "show"])->name('admin.job-profile.show');
        Route::get('/job-profile/edit/{id}',  [ProfileController::class, "edit"])->name('admin.job-profile.edit');
        Route::post('/job-profile/update/{id}',  [ProfileController::class, "update"])->name('admin.job-profile.update');
        Route::get('/job-profile/delete/{id}',  [ProfileController::class, "delete"])->name('admin.job-profile.delete');
    });
});
