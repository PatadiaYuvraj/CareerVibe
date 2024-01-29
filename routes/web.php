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
        // Route::post('search', function (Request $request) {

        //     return redirect()->route('admin.dashboard')->with('info', 'Search is not implemented yet');
        // })->name('admin.search');


        Route::get('/edit-profile',  [AdminController::class, "editProfile"])->name('admin.editProfile');
        Route::post('/update-profile',  [AdminController::class, "updateProfile"])->name('admin.updateProfile');
        Route::get('/change-password',  [AdminController::class, "changePassword"])->name('admin.changePassword');
        Route::post('/change-password',  [AdminController::class, "doChangePassword"])->name('admin.doChangePassword');
        Route::get('/edit-profile-image',  [AdminController::class, "editProfileImage"])->name('admin.editProfileImage');
        Route::post('/update-profile-image',  [AdminController::class, "updateProfileImage"])->name('admin.updateProfileImage');
        // Route::get('/edit-resume-pdf',  [AdminController::class, "editResumePdf"])->name('admin.editResumePdf');
        // Route::post('/update-resume-pdf',  [AdminController::class, "updateResumePdf"])->name('admin.updateResumePdf');
        Route::post('/delete-profile-image',  [AdminController::class, "deleteProfileImage"])->name('admin.deleteProfileImage');
        // add throttle limit 

        // Route::get('/dashboard',  [AdminController::class, "dashboard"])->name('admin.dashboard');
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

        // notifications
        Route::prefix('notifications')->group(function () {
            Route::get('/',  [AdminController::class, "notifications"])->name('admin.notifications');
            Route::get('/mark-all-as-read',  [AdminController::class, "markAllAsRead"])->name('admin.notification.readAll');
            Route::get('/mark-as-read/{id}',  [AdminController::class, "markAsRead"])->name('admin.notification.read');
            Route::get('/mark-as-unread/{id}',  [AdminController::class, "markAsUnread"])->name('admin.notification.unread');
            Route::get('/delete-notification/{id}',  [AdminController::class, "deleteNotification"])->name('admin.notification.delete');
            Route::get('/delete-all-notification',  [AdminController::class, "deleteAllNotification"])->name('admin.notification.deleteAll');
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

        Route::get('/followers',  [CompanyCompanyController::class, "followers"])->name('company.followers');
        Route::get('/all-users',  [CompanyCompanyController::class, "allUsers"])->name('company.allUsers');
        Route::get('/remove-follower/{id}',  [CompanyCompanyController::class, "removeFollower"])->name('company.removeFollower');

        // notifications
        Route::prefix('notifications')->group(function () {
            Route::get('/',  [CompanyCompanyController::class, "notifications"])->name('company.notifications');
            Route::get('/mark-all-as-read',  [CompanyCompanyController::class, "markAllAsRead"])->name('company.notification.readAll');
            Route::get('/mark-as-read/{id}',  [CompanyCompanyController::class, "markAsRead"])->name('company.notification.read');
            Route::get('/mark-as-unread/{id}',  [CompanyCompanyController::class, "markAsUnread"])->name('company.notification.unread');
            Route::get('/delete-notification/{id}',  [CompanyCompanyController::class, "deleteNotification"])->name('company.notification.delete');
            Route::get('/delete-all-notification',  [CompanyCompanyController::class, "deleteAllNotification"])->name('company.notification.deleteAll');
        });

        // posts comments likes
        Route::prefix('post')->group(function () {
            Route::get('/',  [CompanyCompanyController::class, "indexPost"])->name('company.post.index');
            Route::get('/all',  [CompanyCompanyController::class, "allPost"])->name('company.post.all');
            Route::get('/create',  [CompanyCompanyController::class, "createPost"])->name('company.post.create');
            Route::post('/store',  [CompanyCompanyController::class, "storePost"])->name('company.post.store');
            Route::get('/{id}',  [CompanyCompanyController::class, "showPost"])->name('company.post.show');
            Route::get('/edit/{id}',  [CompanyCompanyController::class, "editPost"])->name('company.post.edit');
            Route::post('/update/{id}',  [CompanyCompanyController::class, "updatePost"])->name('company.post.update');
            Route::get('/delete/{id}',  [CompanyCompanyController::class, "deletePost"])->name('company.post.delete');
            Route::get('/like/{id}',  [CompanyCompanyController::class, "likePost"])->name('company.post.like');
            Route::get('/unlike/{id}',  [CompanyCompanyController::class, "unlikePost"])->name('company.post.unlike');
            Route::get('/comment/{id}',  [CompanyCompanyController::class, "commentPost"])->name('company.post.comment');
            Route::get('/uncomment/{id}',  [CompanyCompanyController::class, "uncommentPost"])->name('company.post.uncomment');
        });

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
//     Route::get('/', [FrontUserController::class, "index"])->name('index');
//     Route::get("/logout", [FrontUserController::class, 'logout'])->name('logout');
// });


Route::group(['middleware' => "isUser"], function () {
    Route::prefix('/user')->group(function () {


        Route::get('search', function (Request $request) {

            return redirect()->route('user.dashboard')->with('info', 'Search is not implemented yet');
        })->name('user.search');
        // Route::post('search', function (Request $request) {

        //     return redirect()->route('user.dashboard')->with('info', 'Search is not implemented yet');
        // })->name('user.search');


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

        // notification
        Route::prefix('notifications')->group(function () {
            Route::get('/',  [UserUserController::class, "notifications"])->name('user.notifications');
            Route::get('/mark-all-as-read',  [UserUserController::class, "markAllAsRead"])->name('user.notification.readAll');
            Route::get('/mark-as-read/{id}',  [UserUserController::class, "markAsRead"])->name('user.notification.read');
            Route::get('/mark-as-unread/{id}',  [UserUserController::class, "markAsUnread"])->name('user.notification.unread');
            Route::get('/delete-notification/{id}',  [UserUserController::class, "deleteNotification"])->name('user.notification.delete');
            Route::get('/delete-all-notification',  [UserUserController::class, "deleteAllNotification"])->name('user.notification.deleteAll');
        });

        Route::get('/follow/{id}',  [UserUserController::class, "follow"])->name('user.follow');
        Route::get('/unfollow/{id}',  [UserUserController::class, "unfollow"])->name('user.unfollow');
        Route::get('/followers',  [UserUserController::class, "followers"])->name('user.followers');
        Route::get('/following',  [UserUserController::class, "following"])->name('user.following');
        Route::get('/all-users',  [UserUserController::class, "allUsers"])->name('user.allUsers');
        Route::get('/remove-follower/{id}',  [UserUserController::class, "removeFollower"])->name('user.removeFollower');

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
            // show job 
            Route::get('/company/{id}',  [UserJobController::class, "jobByCompany"])->name('user.job.jobByCompany');
            Route::get('/location/{id}',  [UserJobController::class, "jobByLocation"])->name('user.job.jobByLocation');
            Route::get('/qualification/{id}',  [UserJobController::class, "jobByQualification"])->name('user.job.jobByQualification');
            Route::get('/profile-category/{id}',  [UserJobController::class, "jobByProfileCategory"])->name('user.job.jobByProfileCategory');
            Route::get('/sub-profile/{id}',  [UserJobController::class, "jobBySubProfile"])->name('user.job.jobBySubProfile');
            Route::get('/{id}',  [UserJobController::class, "show"])->name('user.job.show');
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

        // posts comments likes
        Route::prefix('post')->group(function () {
            Route::get('/',  [UserUserController::class, "indexPost"])->name('user.post.index');
            Route::get('/all',  [UserUserController::class, "allPost"])->name('user.post.all');
            Route::get('/create',  [UserUserController::class, "createPost"])->name('user.post.create');
            Route::post('/store',  [UserUserController::class, "storePost"])->name('user.post.store');
            Route::get('/{id}',  [UserUserController::class, "showPost"])->name('user.post.show');
            Route::get('/edit/{id}',  [UserUserController::class, "editPost"])->name('user.post.edit');
            Route::post('/update/{id}',  [UserUserController::class, "updatePost"])->name('user.post.update');
            Route::get('/delete/{id}',  [UserUserController::class, "deletePost"])->name('user.post.delete');
            Route::get('/like/{id}',  [UserUserController::class, "likePost"])->name('user.post.like');
            Route::get('/unlike/{id}',  [UserUserController::class, "unlikePost"])->name('user.post.unlike');
            //comment view page
            Route::get('/comment/{id}',  [UserUserController::class, "commentPostIndex"])->name('user.post.commentIndex');  // comment index page
            Route::get('/comment/{id}/create',  [UserUserController::class, "commentPostCreate"])->name('user.post.commentCreate');  // comment create page
            Route::post('/comment/{id}/store',  [UserUserController::class, "commentPostStore"])->name('user.post.commentStore');  // comment store page
            Route::get('/comment/{id}/edit/{comment_id}',  [UserUserController::class, "commentPostEdit"])->name('user.post.commentEdit');  // comment edit page
            Route::post('/comment/{id}/update/{comment_id}',  [UserUserController::class, "commentPostUpdate"])->name('user.post.commentUpdate');  // comment update page
            Route::get('/comment/{id}/delete/{comment_id}',  [UserUserController::class, "commentPostDelete"])->name('user.post.commentDelete');  // comment delete page
            Route::get('/comment/{id}/like/{comment_id}',  [UserUserController::class, "commentPostLike"])->name('user.post.commentLike');  // comment like page
            Route::get('/comment/{id}/unlike/{comment_id}',  [UserUserController::class, "commentPostUnlike"])->name('user.post.commentUnlike');  // comment unlike page
        });
    });
});
