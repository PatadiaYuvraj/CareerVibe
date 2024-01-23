<?php

// Admin 
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\CompanyController as AdminCompanyController;
use App\Http\Controllers\Admin\JobController as AdminJobController;
use App\Http\Controllers\Admin\LocationController;
use App\Http\Controllers\Admin\QualificationController;
use App\Http\Controllers\Admin\SubProfileController;
use App\Http\Controllers\Admin\ProfileCategoryController;
// Company
use App\Http\Controllers\Company\CompanyController as CompanyCompanyController;
use App\Http\Controllers\Company\JobController as CompanyJobController;
// User
use App\Http\Controllers\User\JobController as UserJobController;
use App\Http\Controllers\User\UserController as UserUserController;
use App\Http\Controllers\User\CompanyController as UserCompanyController;
use App\Http\Controllers\TestController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/checkAuth',  function () {
    dd([
        "isUser"    => auth()->guard('user')->check(),
        "isCompany" => auth()->guard('company')->check(),
        "isAdmin"   => auth()->guard('admin')->check(),
    ]);
})->name('checkAuth');

Route::get('/test', [TestController::class, "test"])->name('test');
Route::post('/testing',  [TestController::class, "testing"])->name('testing');


Route::group(['middleware' => "isGuest"], function () {

    // Route::get('/login',  [FrontUserController::class, "login"])->name('login');
    // Route::get('/register', [FrontUserController::class, "register"])->name('register');
    // Route::post('/login', [FrontUserController::class, "doLogin"])->name('doLogin');
    // Route::post('/register', [FrontUserController::class, "doRegister"])->name('doRegister');

    // User Routes
    Route::prefix('/user')->group(function () {
        Route::get('/login',  [UserUserController::class, "login"])->name('user.login');
        Route::get('/register', [UserUserController::class, "register"])->name('user.register');
        Route::post('/login', [UserUserController::class, "doLogin"])->name('user.doLogin');
        Route::post('/register', [UserUserController::class, "doRegister"])->name('user.doRegister');
    });

    // Admin Routes 
    Route::prefix('/admin')->group(function () {
        Route::get('/login',  [AdminController::class, "login"])->name('admin.login');
        Route::get('/register', [AdminController::class, "register"])->name('admin.register');
        Route::post('/login', [AdminController::class, "doLogin"])->name('admin.doLogin');
        Route::post('/register', [AdminController::class, "doRegister"])->name('admin.doRegister');
    });

    // Company Routes
    Route::prefix('/company')->group(function () {
        Route::get('/login',  [CompanyCompanyController::class, "login"])->name('company.login');
        Route::get('/register', [CompanyCompanyController::class, "register"])->name('company.register');
        Route::post('/login', [CompanyCompanyController::class, "doLogin"])->name('company.doLogin');
        Route::post('/register', [CompanyCompanyController::class, "doRegister"])->name('company.doRegister');
    });
});



Route::group(['middleware' => "isAdmin"], function () {
    Route::prefix('/admin')->group(function () {

        Route::get('search', function (Request $request) {

            return redirect()->route('admin.dashboard')->with('info', 'Search is not implemented yet');
        })->name('admin.search');
        Route::post('search', function (Request $request) {

            return redirect()->route('admin.dashboard')->with('info', 'Search is not implemented yet');
        })->name('admin.search');


        Route::get('/edit-profile',  [AdminController::class, "editProfile"])->name('admin.editProfile');
        Route::post('/update-profile',  [AdminController::class, "updateProfile"])->name('admin.updateProfile');
        Route::get('/change-password',  [AdminController::class, "changePassword"])->name('admin.changePassword');
        Route::post('/change-password',  [AdminController::class, "doChangePassword"])->name('admin.doChangePassword');
        Route::get('/edit-profile-image',  [AdminController::class, "editProfileImage"])->name('admin.editProfileImage');
        Route::post('/update-profile-image',  [AdminController::class, "updateProfileImage"])->name('admin.updateProfileImage');
        // Route::get('/edit-resume-pdf',  [AdminController::class, "editResumePdf"])->name('admin.editResumePdf');
        // Route::post('/update-resume-pdf',  [AdminController::class, "updateResumePdf"])->name('admin.updateResumePdf');
        Route::post('/delete-profile-image',  [AdminController::class, "deleteProfileImage"])->name('admin.deleteProfileImage');
        Route::get('/dashboard',  [AdminController::class, "dashboard"])->name('admin.dashboard');
        Route::get('/logout',  [AdminController::class, "logout"])->name('admin.logout');

        Route::prefix('user')->group(function () {
            Route::get('/create',  [AdminUserController::class, "create"])->name('admin.user.create');
            Route::post('/store',  [AdminUserController::class, "store"])->name('admin.user.store');
            Route::get('/',  [AdminUserController::class, "index"])->name('admin.user.index');
            Route::get('/{id}',  [AdminUserController::class, "show"])->name('admin.user.show');
            Route::post('/edit/{id}',  [AdminUserController::class, "edit"])->name('admin.user.edit');
            Route::post('/update/{id}',  [AdminUserController::class, "update"])->name('admin.user.update');
            Route::delete('/delete/{id}',  [AdminUserController::class, "delete"])->name('admin.user.delete');
            Route::post('/update-profile-image/{id}',  [AdminUserController::class, "updateUserProfileImage"])->name('admin.user.updateProfileImage');
            Route::post('/update-resume-pdf/{id}',  [AdminUserController::class, "updateUserResume"])->name('admin.user.updateResumePdf');
            Route::delete('/delete-profile-image/{id}',  [AdminUserController::class, "deleteUserProfileImage"])->name('admin.user.deleteProfileImage');
            Route::delete('/delete-resume-pdf/{id}',  [AdminUserController::class, "deleteUserResume"])->name('admin.user.deleteResumePdf');
        });
        Route::prefix('company')->group(function () {
            Route::get('/create',  [AdminCompanyController::class, "create"])->name('admin.company.create');
            Route::post('/store',  [AdminCompanyController::class, "store"])->name('admin.company.store');
            Route::get('/',  [AdminCompanyController::class, "index"])->name('admin.company.index');
            Route::get('/{id}',  [AdminCompanyController::class, "show"])->name('admin.company.show');
            Route::get('/edit/{id}',  [AdminCompanyController::class, "edit"])->name('admin.company.edit');
            Route::post('/update/{id}',  [AdminCompanyController::class, "update"])->name('admin.company.update');
            Route::get('/delete/{id}',  [AdminCompanyController::class, "delete"])->name('admin.company.delete');
            Route::get('/toggle-verified/{id}/{is_verified}',  [AdminCompanyController::class, "toggleVerified"])->name('admin.company.toggleVerified');
            Route::post('/store-profile-image/{id}',  [AdminCompanyController::class, "storeProfileImage"])->name('admin.company.storeProfileImage');
            Route::post('/update-profile-image/{id}',  [AdminCompanyController::class, "updateCompanyProfileImage"])->name('admin.company.updateProfileImage');
            Route::post('/delete-profile-image/{id}',  [AdminCompanyController::class, "deleteProfileImage"])->name('admin.company.deleteProfileImage');
        });

        Route::prefix('job')->group(function () {
            Route::get('/create/{id}',  [AdminJobController::class, "create"])->name('admin.job.create');
            Route::post('/store/{id}',  [AdminJobController::class, "store"])->name('admin.job.store');
            Route::get('/',  [AdminJobController::class, "index"])->name('admin.job.index');
            Route::get('/{id}',  [AdminJobController::class, "show"])->name('admin.job.show');
            Route::get('/edit/{id}',  [AdminJobController::class, "edit"])->name('admin.job.edit');
            Route::post('/update/{id}',  [AdminJobController::class, "update"])->name('admin.job.update');
            Route::get('/delete/{id}',  [AdminJobController::class, "delete"])->name('admin.job.delete');
            Route::get('/toggle-verified/{id}/{is_verified}',  [AdminJobController::class, "toggleVerified"])->name('admin.job.toggleVerified');
            Route::get('/toggle-featured/{id}/{is_featured}',  [AdminJobController::class, "toggleFeatured"])->name('admin.job.toggleFeatured');
            Route::get('/toggle-active/{id}/{is_active}',  [AdminJobController::class, "toggleActive"])->name('admin.job.toggleActive');
        });

        Route::prefix('profile-category')->group(function () {
            Route::get('/create',  [ProfileCategoryController::class, "create"])->name('admin.profile-category.create');
            Route::post('/store',  [ProfileCategoryController::class, "store"])->name('admin.profile-category.store');
            Route::get('/',  [ProfileCategoryController::class, "index"])->name('admin.profile-category.index');
            Route::get('/{id}',  [ProfileCategoryController::class, "show"])->name('admin.profile-category.show');
            Route::get('/edit/{id}',  [ProfileCategoryController::class, "edit"])->name('admin.profile-category.edit');
            Route::post('/update/{id}',  [ProfileCategoryController::class, "update"])->name('admin.profile-category.update');
            Route::get('/delete/{id}',  [ProfileCategoryController::class, "delete"])->name('admin.profile-category.delete');
        });

        Route::prefix('sub-profile')->group(function () {
            Route::get('/create',  [SubProfileController::class, "create"])->name('admin.sub-profile.create');
            Route::post('/store',  [SubProfileController::class, "store"])->name('admin.sub-profile.store');
            Route::get('/',  [SubProfileController::class, "index"])->name('admin.sub-profile.index');
            Route::get('/{id}',  [SubProfileController::class, "show"])->name('admin.sub-profile.show');
            Route::get('/edit/{id}',  [SubProfileController::class, "edit"])->name('admin.sub-profile.edit');
            Route::post('/update/{id}',  [SubProfileController::class, "update"])->name('admin.sub-profile.update');
            Route::get('/delete/{id}',  [SubProfileController::class, "delete"])->name('admin.sub-profile.delete');
        });

        Route::prefix('location')->group(function () {
            Route::get('/create',  [LocationController::class, "create"])->name('admin.location.create');
            Route::post('/store',  [LocationController::class, "store"])->name('admin.location.store');
            Route::get('/',  [LocationController::class, "index"])->name('admin.location.index');
            Route::get('/{id}',  [LocationController::class, "show"])->name('admin.location.show');
            Route::get('/edit/{id}',  [LocationController::class, "edit"])->name('admin.location.edit');
            Route::post('/update/{id}',  [LocationController::class, "update"])->name('admin.location.update');
            Route::get('/delete/{id}',  [LocationController::class, "delete"])->name('admin.location.delete');
        });

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

Route::group(['middleware' => "isCompany"], function () {

    Route::prefix('/company')->group(function () {
        Route::get('/edit-profile',  [CompanyCompanyController::class, "editProfile"])->name('company.editProfile');
        Route::post('/update-profile',  [CompanyCompanyController::class, "updateProfile"])->name('company.updateProfile');
        Route::get('/change-password',  [CompanyCompanyController::class, "changePassword"])->name('company.changePassword');
        Route::post('/change-password',  [CompanyCompanyController::class, "doChangePassword"])->name('company.doChangePassword');
        Route::get('/edit-profile-image',  [CompanyCompanyController::class, "editProfileImage"])->name('company.editProfileImage');
        Route::post('/update-profile-image',  [CompanyCompanyController::class, "updateProfileImage"])->name('company.updateProfileImage');
        Route::post('/delete-profile-image',  [CompanyCompanyController::class, "deleteProfileImage"])->name('company.deleteProfileImage');
        Route::get('/dashboard',  [CompanyCompanyController::class, "dashboard"])->name('company.dashboard');
        Route::get('/logout',  [CompanyCompanyController::class, "logout"])->name('company.logout');

        Route::prefix('job')->group(function () {
            Route::get('/create',  [CompanyJobController::class, "create"])->name('company.job.create');
            Route::post('/store',  [CompanyJobController::class, "store"])->name('company.job.store');
            Route::get('/',  [CompanyJobController::class, "index"])->name('company.job.index');
            Route::get('/{id}',  [CompanyJobController::class, "show"])->name('company.job.show');
            Route::get('/edit/{id}',  [CompanyJobController::class, "edit"])->name('company.job.edit');
            Route::post('/update/{id}',  [CompanyJobController::class, "update"])->name('company.job.update');
            Route::get('/delete/{id}',  [CompanyJobController::class, "delete"])->name('company.job.delete');
            Route::get('/toggle-featured/{id}/{is_featured}',  [CompanyJobController::class, "toggleFeatured"])->name('company.job.toggleFeatured');
            Route::get('/toggle-active/{id}/{is_active}',  [CompanyJobController::class, "toggleActive"])->name('company.job.toggleActive');
        });
    });
});

// Route::group(['middleware' => "isUser"], function () {
//     // Route::get('/', [FrontUserController::class, "index"])->name('index');
//     // Route::get("/logout", [FrontUserController::class, 'logout'])->name('logout');
//     // Route::get('/about', [FrontUserController::class, "about"])->name('about');
//     // Route::get('/blog-single', [FrontUserController::class, "blog_single"])->name('blog-single');
//     // Route::get('/blog', [FrontUserController::class, "blog"])->name('blog');
//     // Route::get('/contact', [FrontUserController::class, "contact"])->name('contact');
//     // Route::get('/faq', [FrontUserController::class, "faq"])->name('faq');
//     // Route::get('/gallery', [FrontUserController::class, "gallery"])->name('gallery');
//     // Route::get('/job-listings', [FrontUserController::class, "job_listings"])->name('job-listings');
//     // Route::get('/job-single', [FrontUserController::class, "job_single"])->name('job-single');
//     // Route::get('/portfolio-single', [FrontUserController::class, "portfolio_single"])->name('portfolio-single');
//     // Route::get('/portfolio', [FrontUserController::class, "portfolio"])->name('portfolio');
//     // Route::get('/post-job', [FrontUserController::class, "post_job"])->name('post-job');
//     // Route::get('/service-sinlge', [FrontUserController::class, "service_sinlge"])->name('service-sinlge');
//     // Route::get('/services', [FrontUserController::class, "services"])->name('services');
//     // Route::get('/testimonials', [FrontUserController::class, "testimonials"])->name('testimonials');

// });


Route::group(['middleware' => "isUser"], function () {
    Route::prefix('/user')->group(function () {


        Route::get('search', function (Request $request) {

            return redirect()->route('user.dashboard')->with('info', 'Search is not implemented yet');
        })->name('user.search');
        Route::post('search', function (Request $request) {

            return redirect()->route('user.dashboard')->with('info', 'Search is not implemented yet');
        })->name('user.search');


        Route::get('/dashboard',  [UserUserController::class, "dashboard"])->name('user.dashboard');
        Route::get('/logout',  [UserUserController::class, "logout"])->name('user.logout');
        Route::get('/edit-profile',  [UserUserController::class, "editProfile"])->name('user.editProfile');
        Route::post('/update-profile',  [UserUserController::class, "updateProfile"])->name('user.updateProfile');
        Route::get('/change-password',  [UserUserController::class, "changePassword"])->name('user.changePassword');
        Route::post('/change-password',  [UserUserController::class, "doChangePassword"])->name('user.doChangePassword');
        Route::get('/edit-profile-image',  [UserUserController::class, "editProfileImage"])->name('user.editProfileImage');
        Route::post('/update-profile-image',  [UserUserController::class, "updateProfileImage"])->name('user.updateProfileImage');
        Route::post('/delete-profile-image',  [UserUserController::class, "deleteProfileImage"])->name('user.deleteProfileImage');
        Route::get('/edit-resume-pdf',  [UserUserController::class, "editResumePdf"])->name('user.editResumePdf');
        Route::post('/update-resume-pdf',  [UserUserController::class, "updateResumePdf"])->name('user.updateResumePdf');
        Route::get('/delete-resume-pdf',  [UserUserController::class, "deleteResumePdf"])->name('user.deleteResumePdf');

        Route::get('/follow/{id}',  [UserUserController::class, "follow"])->name('user.follow');
        Route::get('/unfollow/{id}',  [UserUserController::class, "unfollow"])->name('user.unfollow');
        Route::get('/followers',  [UserUserController::class, "followers"])->name('user.followers');
        Route::get('/following',  [UserUserController::class, "following"])->name('user.following');
        Route::get('/all-users',  [UserUserController::class, "allUsers"])->name('user.allUsers');

        Route::prefix('job')->group(function () {
            Route::get('/applied-jobs',  [UserJobController::class, "appliedJobs"])->name('user.job.appliedJobs');
            Route::get('/saved-jobs',  [UserJobController::class, "savedJobs"])->name('user.job.savedJobs');
            Route::get('/',  [UserJobController::class, "index"])->name('user.job.index');
            // Route::get('/search',  [UserJobController::class, "search"])->name('user.job.search');
            // Route::post('/search',  [UserJobController::class, "doSearch"])->name('user.job.doSearch'); 
            Route::get('/apply/{id}',  [UserJobController::class, "apply"])->name('user.job.apply');
            Route::get('/unapply/{id}',  [UserJobController::class, "unapply"])->name('user.job.unapply');
            // Route::get('/cancel-applied-job/{id}',  [UserJobController::class, "cancelAppliedJob"])->name('user.job.cancelAppliedJob');
            Route::get('/save-job/{id}',  [UserJobController::class, "saveJob"])->name('user.job.saveJob');
            Route::get('/unsave-job/{id}',  [UserJobController::class, "unsaveJob"])->name('user.job.unsaveJob');
        });
        //  all Company
        Route::prefix('company')->group(function () {
            Route::get('/',  [UserCompanyController::class, "allCompany"])->name('user.company.index');
            Route::get('/{id}',  [UserCompanyController::class, "showCompany"])->name('user.company.show');
            Route::get('/followers/{id}',  [UserCompanyController::class, "followers"])->name('user.company.followers');
            http: //127.0.0.1:8000/user/unfollow/1
            Route::get('/follow/{id}',  [UserCompanyController::class, "followCompany"])->name('user.company.follow');
            Route::get('/unfollow/{id}',  [UserCompanyController::class, "unfollowCompany"])->name('user.company.unfollow');
        });
        // Route::get('/company/{id}',  [UserJobController::class, "jobByCompany"])->name('user.job.jobByCompany');
        // Route::get('/location/{id}',  [UserJobController::class, "jobByLocation"])->name('user.job.jobByLocation');
        // Route::get('/qualification/{id}',  [UserJobController::class, "jobByQualification"])->name('user.job.jobByQualification');
        // Route::get('/profile-category/{id}',  [UserJobController::class, "jobByProfileCategory"])->name('user.job.jobByProfileCategory');
        // Route::get('/sub-profile/{id}',  [UserJobController::class, "jobBySubProfile"])->name('user.job.jobBySubProfile');
        // Route::get('/{id}',  [UserJobController::class, "show"])->name('user.job.show');
    });
});

// TODO:

// When to send email

// When user apply for job -> ['user', 'company']
// When company post new job -> ['user'=> 'New job available', 'company'=> 'Your job is posted']
// When admin post job -> ['admin']
// When user save job -> ['user']
// When user unsave job -> ['user']
// When user cancel applied job -> ['user', 'company']
// When user update profile -> ['user']
// When user update profile image -> ['user']
// When user update resume pdf -> ['user']
// When company update profile -> ['company']
// When company update profile image -> ['company']
// When admin update profile -> ['admin']
// When admin update profile image -> ['admin']
// When admin verify company -> ['company']
// When admin verify job -> ['company']
// When admin verify user -> ['user']
// When company post new job -> ['user'=> 'New job available', 'company'=> 'Your job is posted']



// email verification annd forgot password
