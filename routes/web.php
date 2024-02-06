<?php

// Admin 
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\CompanyController as AdminCompanyController;
use App\Http\Controllers\Admin\JobController as AdminJobController;
use App\Http\Controllers\Admin\LocationController;
use App\Http\Controllers\Admin\QualificationController;
use App\Http\Controllers\Admin\SubProfileController;
use App\Http\Controllers\Admin\ProfileCategoryController;


// Company
use App\Http\Controllers\Company\AuthController as CompanyAuthController;
use App\Http\Controllers\Company\NotificationsController as CompanyNotificationsController;
use App\Http\Controllers\Company\JobController as CompanyJobController;
use App\Http\Controllers\Company\FollowsController as CompanyFollowsController;
use App\Http\Controllers\Company\PostsController as CompanyPostsController;


// User
use App\Http\Controllers\User\JobController as UserJobController;
use App\Http\Controllers\User\AuthController as UserAuthController;
use App\Http\Controllers\User\FollowsController as UserFollowsController;
use App\Http\Controllers\User\NotificationsController as UserNotificationsController;
use App\Http\Controllers\User\PostsController as UserPostsController;


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
        Route::get('/login',  [UserAuthController::class, "login"])->name('user.login');
        Route::get('/register', [UserAuthController::class, "register"])->name('user.register');
        Route::post('/login', [UserAuthController::class, "doLogin"])->name('user.doLogin');
        Route::post('/register', [UserAuthController::class, "doRegister"])->name('user.doRegister');
        Route::get('/verify-email/{token}',  [UserAuthController::class, "verifyEmail"])->name('user.verifyEmail');
        Route::get('/resend-verification-email',  [UserAuthController::class, "resendVerificationEmail"])->name('user.resendVerificationEmail');
        Route::get('/send-verification-email',  [UserAuthController::class, "sendVerificationEmail"])->name('user.sendVerificationEmail');
        Route::get('/forgot-password',  [UserAuthController::class, "forgotPassword"])->name('user.forgotPassword');
        Route::post('/forgot-password',  [UserAuthController::class, "doForgotPassword"])->name('user.doForgotPassword');
        Route::get('/reset-password/{token}',  [UserAuthController::class, "resetPassword"])->name('user.resetPassword');
        Route::post('/reset-password/{token}',  [UserAuthController::class, "doResetPassword"])->name('user.doResetPassword');
    });

    // Admin Routes 
    Route::prefix('/admin')->group(function () {
        Route::get('/login',  [AdminAuthController::class, "login"])->name('admin.login');
        Route::get('/register', [AdminAuthController::class, "register"])->name('admin.register');
        Route::post('/login', [AdminAuthController::class, "doLogin"])->name('admin.doLogin');
        Route::post('/register', [AdminAuthController::class, "doRegister"])->name('admin.doRegister');
        Route::get('/verify-email/{token}',  [AdminAuthController::class, "verifyEmail"])->name('admin.verifyEmail');
        Route::get('/resend-verification-email',  [AdminAuthController::class, "resendVerificationEmail"])->name('admin.resendVerificationEmail');
        Route::get('/send-verification-email',  [AdminAuthController::class, "sendVerificationEmail"])->name('admin.sendVerificationEmail');
        Route::get('/forgot-password',  [AdminAuthController::class, "forgotPassword"])->name('admin.forgotPassword');
        Route::post('/forgot-password',  [AdminAuthController::class, "doForgotPassword"])->name('admin.doForgotPassword');
        Route::get('/reset-password/{token}',  [AdminAuthController::class, "resetPassword"])->name('admin.resetPassword');
        Route::post('/reset-password/{token}',  [AdminAuthController::class, "doResetPassword"])->name('admin.doResetPassword');
    });

    // Company Routes
    Route::prefix('/company')->group(function () {
        Route::get('/login',  [CompanyAuthController::class, "login"])->name('company.login');
        Route::get('/register', [CompanyAuthController::class, "register"])->name('company.register');
        Route::post('/login', [CompanyAuthController::class, "doLogin"])->name('company.doLogin');
        Route::post('/register', [CompanyAuthController::class, "doRegister"])->name('company.doRegister');
        Route::get('/verify-email/{token}',  [CompanyAuthController::class, "verifyEmail"])->name('company.verifyEmail');
        Route::get('/resend-verification-email',  [CompanyAuthController::class, "resendVerificationEmail"])->name('company.resendVerificationEmail');
        Route::get('/send-verification-email',  [CompanyAuthController::class, "sendVerificationEmail"])->name('company.sendVerificationEmail');
        Route::get('/forgot-password',  [CompanyAuthController::class, "forgotPassword"])->name('company.forgotPassword');
        Route::post('/forgot-password',  [CompanyAuthController::class, "doForgotPassword"])->name('company.doForgotPassword');
        Route::get('/reset-password/{token}',  [CompanyAuthController::class, "resetPassword"])->name('company.resetPassword');
        Route::post('/reset-password/{token}',  [CompanyAuthController::class, "doResetPassword"])->name('company.doResetPassword');
    });
});



Route::group(['middleware' => "isAdmin"], function () {
    Route::prefix('/admin')->group(function () {

        Route::get('search', function (Request $request) {

            return redirect()->route('admin.dashboard')->with('info', 'Search is not implemented yet');
        })->name('admin.search');
        Route::post('search', function (Request $request) {

            return redirect()->route('admin.dashboard')->with('info', 'Search is not implemented yet');
        })->name('admin.doSearch');


        Route::get('/edit-profile',  [AdminAuthController::class, "editProfile"])->name('admin.editProfile');
        Route::post('/update-profile',  [AdminAuthController::class, "updateProfile"])->name('admin.updateProfile');
        Route::get('/change-password',  [AdminAuthController::class, "changePassword"])->name('admin.changePassword');
        Route::post('/change-password',  [AdminAuthController::class, "doChangePassword"])->name('admin.doChangePassword');
        Route::get('/edit-profile-image',  [AdminAuthController::class, "editProfileImage"])->name('admin.editProfileImage');
        Route::post('/update-profile-image',  [AdminAuthController::class, "updateProfileImage"])->name('admin.updateProfileImage');
        // Route::get('/edit-resume-pdf',  [AdminAuthController::class, "editResumePdf"])->name('admin.editResumePdf');
        // Route::post('/update-resume-pdf',  [AdminAuthController::class, "updateResumePdf"])->name('admin.updateResumePdf');
        Route::post('/delete-profile-image',  [AdminAuthController::class, "deleteProfileImage"])->name('admin.deleteProfileImage');
        // add throttle limit 

        // Route::get('/dashboard',  [AdminAuthController::class, "dashboard"])->name('admin.dashboard');
        Route::get('/dashboard',  [AdminAuthController::class, "dashboard"])->name('admin.dashboard');
        Route::get('/logout',  [AdminAuthController::class, "logout"])->name('admin.logout');

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
            Route::get('/livewire',  [ProfileCategoryController::class, "livewire"])->name('admin.profile-category.livewire');
            Route::get('/create',  [ProfileCategoryController::class, "create"])->name('admin.profile-category.create');
            Route::post('/store',  [ProfileCategoryController::class, "store"])->name('admin.profile-category.store');
            Route::get('/',  [ProfileCategoryController::class, "index"])->name('admin.profile-category.index');
            Route::get('/{id}',  [ProfileCategoryController::class, "show"])->name('admin.profile-category.show');
            Route::get('/edit/{id}',  [ProfileCategoryController::class, "edit"])->name('admin.profile-category.edit');
            Route::post('/update/{id}',  [ProfileCategoryController::class, "update"])->name('admin.profile-category.update');
            Route::get('/delete/{id}',  [ProfileCategoryController::class, "delete"])->name('admin.profile-category.delete');
        });

        Route::prefix('sub-profile')->group(function () {
            Route::get('/livewire',  [SubProfileController::class, "livewire"])->name('admin.sub-profile.livewire');
            Route::get('/create',  [SubProfileController::class, "create"])->name('admin.sub-profile.create');
            Route::post('/store',  [SubProfileController::class, "store"])->name('admin.sub-profile.store');
            Route::get('/',  [SubProfileController::class, "index"])->name('admin.sub-profile.index');
            Route::get('/{id}',  [SubProfileController::class, "show"])->name('admin.sub-profile.show');
            Route::get('/edit/{id}',  [SubProfileController::class, "edit"])->name('admin.sub-profile.edit');
            Route::post('/update/{id}',  [SubProfileController::class, "update"])->name('admin.sub-profile.update');
            Route::get('/delete/{id}',  [SubProfileController::class, "delete"])->name('admin.sub-profile.delete');
        });

        Route::prefix('location')->group(function () {
            Route::get('/livewire',  [LocationController::class, "livewire"])->name('admin.location.livewire');
            Route::get('/getAll',  [LocationController::class, "getAll"])->name('admin.location.getAll');
            Route::post('/store',  [LocationController::class, "store"])->name('admin.location.store');
            Route::get('/',  [LocationController::class, "index"])->name('admin.location.index');
            Route::get('/show',  [LocationController::class, "show"])->name('admin.location.show');
            Route::get('/edit',  [LocationController::class, "edit"])->name('admin.location.edit');
            Route::post('/update',  [LocationController::class, "update"])->name('admin.location.update');
            Route::get('/delete',  [LocationController::class, "delete"])->name('admin.location.delete');
        });

        Route::prefix('qualification')->group(function () {
            Route::get('/livewire',  [QualificationController::class, "livewire"])->name('admin.qualification.livewire');
            Route::post('/store',  [QualificationController::class, "store"])->name('admin.qualification.store');
            Route::get('/',  [QualificationController::class, "index"])->name('admin.qualification.index');
            Route::get('/getAll',  [QualificationController::class, "getAll"])->name('admin.qualification.getAll');
            Route::get('/show',  [QualificationController::class, "show"])->name('admin.qualification.show');
            Route::get('/edit',  [QualificationController::class, "edit"])->name('admin.qualification.edit');
            Route::post('/update',  [QualificationController::class, "update"])->name('admin.qualification.update');
            Route::get('/delete',  [QualificationController::class, "delete"])->name('admin.qualification.delete');
        });


        // notifications
        Route::prefix('notifications')->group(function () {
            Route::get('/',  [AdminAuthController::class, "notifications"])->name('admin.notifications');
            Route::get('/mark-all-as-read',  [AdminAuthController::class, "markAllAsRead"])->name('admin.notification.readAll');
            Route::get('/mark-as-read/{id}',  [AdminAuthController::class, "markAsRead"])->name('admin.notification.read');
            Route::get('/mark-as-unread/{id}',  [AdminAuthController::class, "markAsUnread"])->name('admin.notification.unread');
            Route::get('/delete-notification/{id}',  [AdminAuthController::class, "deleteNotification"])->name('admin.notification.delete');
            Route::get('/delete-all-notification',  [AdminAuthController::class, "deleteAllNotification"])->name('admin.notification.deleteAll');
        });
    });
});

Route::group(['middleware' => "isCompany"], function () {




    Route::prefix('/company')->group(function () {
        Route::get('/edit-profile',  [CompanyAuthController::class, "editProfile"])->name('company.editProfile');
        Route::post('/update-profile',  [CompanyAuthController::class, "updateProfile"])->name('company.updateProfile');
        Route::get('/change-password',  [CompanyAuthController::class, "changePassword"])->name('company.changePassword');
        Route::post('/change-password',  [CompanyAuthController::class, "doChangePassword"])->name('company.doChangePassword');
        Route::get('/edit-profile-image',  [CompanyAuthController::class, "editProfileImage"])->name('company.editProfileImage');
        Route::post('/update-profile-image',  [CompanyAuthController::class, "updateProfileImage"])->name('company.updateProfileImage');
        Route::post('/delete-profile-image',  [CompanyAuthController::class, "deleteProfileImage"])->name('company.deleteProfileImage');
        Route::get('/dashboard',  [CompanyAuthController::class, "dashboard"])->name('company.dashboard');
        Route::get('/logout',  [CompanyAuthController::class, "logout"])->name('company.logout');

        Route::get('/followers',  [CompanyFollowsController::class, "followers"])->name('company.followers');
        Route::get('/all-users',  [CompanyFollowsController::class, "allUsers"])->name('company.allUsers');
        Route::get('/remove-follower/{id}',  [CompanyFollowsController::class, "removeFollower"])->name('company.removeFollower');

        // notifications
        Route::prefix('notifications')->group(function () {
            Route::get('/',  [CompanyNotificationsController::class, "notifications"])->name('company.notifications');
            Route::get('/mark-all-as-read',  [CompanyNotificationsController::class, "markAllAsRead"])->name('company.notification.readAll');
            Route::get('/mark-as-read/{id}',  [CompanyNotificationsController::class, "markAsRead"])->name('company.notification.read');
            Route::get('/mark-as-unread/{id}',  [CompanyNotificationsController::class, "markAsUnread"])->name('company.notification.unread');
            Route::get('/delete-notification/{id}',  [CompanyNotificationsController::class, "deleteNotification"])->name('company.notification.delete');
            Route::get('/delete-all-notification',  [CompanyNotificationsController::class, "deleteAllNotification"])->name('company.notification.deleteAll');
        });

        // posts comments likes
        Route::prefix('post')->group(function () {
            Route::get('/',  [CompanyPostsController::class, "indexPost"])->name('company.post.index');
            Route::get('/all',  [CompanyPostsController::class, "allPost"])->name('company.post.all');
            Route::get('/create',  [CompanyPostsController::class, "createPost"])->name('company.post.create');
            Route::post('/store',  [CompanyPostsController::class, "storePost"])->name('company.post.store');
            Route::get('/{id}',  [CompanyPostsController::class, "showPost"])->name('company.post.show');
            Route::get('/edit/{id}',  [CompanyPostsController::class, "editPost"])->name('company.post.edit');
            Route::post('/update/{id}',  [CompanyPostsController::class, "updatePost"])->name('company.post.update');
            Route::get('/delete/{id}',  [CompanyPostsController::class, "deletePost"])->name('company.post.delete');
            Route::get('/like/{id}',  [CompanyPostsController::class, "likePost"])->name('company.post.like');
            Route::get('/unlike/{id}',  [CompanyPostsController::class, "unlikePost"])->name('company.post.unlike');

            // comments profix
            Route::prefix('comment')->group(function () {
                Route::get('/{id}',  [CompanyPostsController::class, "commentPostIndex"])->name('company.post.commentIndex');  // comment index page
                Route::get('/{id}/create',  [CompanyPostsController::class, "commentPostCreate"])->name('company.post.commentCreate');  // comment create page
                Route::post('/{id}/store',  [CompanyPostsController::class, "commentPostStore"])->name('company.post.commentStore');  // comment store page
                Route::get('/{id}/edit/{comment_id}',  [CompanyPostsController::class, "commentPostEdit"])->name('company.post.commentEdit');  // comment edit page
                Route::post('/{id}/update/{comment_id}',  [CompanyPostsController::class, "commentPostUpdate"])->name('company.post.commentUpdate');  // comment update page
                Route::get('/{id}/delete/{comment_id}',  [CompanyPostsController::class, "commentPostDelete"])->name('company.post.commentDelete');  // comment delete page
                Route::get('/{id}/like/{comment_id}',  [CompanyPostsController::class, "commentPostLike"])->name('company.post.commentLike');  // comment like page
                Route::get('/{id}/unlike/{comment_id}',  [CompanyPostsController::class, "commentPostUnlike"])->name('company.post.commentUnlike');  // comment unlike page
            });
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


// Route::group(['middleware' => "isUser"], function () {
//     Route::prefix('/user')->group(function () {


//         Route::get('search', function (Request $request) {

//             return redirect()->route('user.dashboard')->with('info', 'Search is not implemented yet');
//         })->name('user.search');
//         Route::post('search', function (Request $request) {

//             return redirect()->route('user.dashboard')->with('info', 'Search is not implemented yet');
//         })->name('user.doSearch');


//         Route::get('/dashboard',  [UserAuthController::class, "dashboard"])->name('user.dashboard');
//         Route::get('/logout',  [UserAuthController::class, "logout"])->name('user.logout');
//         Route::get('/edit-profile',  [UserAuthController::class, "editProfile"])->name('user.editProfile');
//         Route::post('/update-profile',  [UserAuthController::class, "updateProfile"])->name('user.updateProfile');
//         Route::get('/change-password',  [UserAuthController::class, "changePassword"])->name('user.changePassword');
//         Route::post('/change-password',  [UserAuthController::class, "doChangePassword"])->name('user.doChangePassword');
//         Route::get('/edit-profile-image',  [UserAuthController::class, "editProfileImage"])->name('user.editProfileImage');
//         Route::post('/update-profile-image',  [UserAuthController::class, "updateProfileImage"])->name('user.updateProfileImage');
//         Route::post('/delete-profile-image',  [UserAuthController::class, "deleteProfileImage"])->name('user.deleteProfileImage');
//         Route::get('/edit-resume-pdf',  [UserAuthController::class, "editResumePdf"])->name('user.editResumePdf');
//         Route::post('/update-resume-pdf',  [UserAuthController::class, "updateResumePdf"])->name('user.updateResumePdf');
//         Route::get('/delete-resume-pdf',  [UserAuthController::class, "deleteResumePdf"])->name('user.deleteResumePdf');

//         // notification
//         Route::prefix('notifications')->group(function () {
//             Route::get('/',  [UserNotificationsController::class, "notifications"])->name('user.notifications');
//             Route::get('/mark-all-as-read',  [UserNotificationsController::class, "markAllAsRead"])->name('user.notification.readAll');
//             Route::get('/mark-as-read/{id}',  [UserNotificationsController::class, "markAsRead"])->name('user.notification.read');
//             Route::get('/mark-as-unread/{id}',  [UserNotificationsController::class, "markAsUnread"])->name('user.notification.unread');
//             Route::get('/delete-notification/{id}',  [UserNotificationsController::class, "deleteNotification"])->name('user.notification.delete');
//             Route::get('/delete-all-notification',  [UserNotificationsController::class, "deleteAllNotification"])->name('user.notification.deleteAll');
//         });

//         Route::get('/follow/{id}',  [UserFollowsController::class, "follow"])->name('user.follow');
//         Route::get('/unfollow/{id}',  [UserFollowsController::class, "unfollow"])->name('user.unfollow');
//         Route::get('/followers',  [UserFollowsController::class, "followers"])->name('user.followers');
//         Route::get('/following',  [UserFollowsController::class, "following"])->name('user.following');
//         Route::get('/all-users',  [UserFollowsController::class, "allUsers"])->name('user.allUsers');
//         Route::get('/remove-follower/{id}',  [UserFollowsController::class, "removeFollower"])->name('user.removeFollower');

//         //  all Company
//         Route::prefix('company')->group(function () {
//             Route::get('/',  [UserFollowsController::class, "allCompany"])->name('user.company.index');
//             Route::get('/{id}',  [UserFollowsController::class, "showCompany"])->name('user.company.show');
//             Route::get('/followers/{id}',  [UserFollowsController::class, "followers"])->name('user.company.followers');
//             http: //127.0.0.1:8000/user/unfollow/1
//             Route::get('/follow/{id}',  [UserFollowsController::class, "followCompany"])->name('user.company.follow');
//             Route::get('/unfollow/{id}',  [UserFollowsController::class, "unfollowCompany"])->name('user.company.unfollow');
//         });

//         Route::prefix('job')->group(function () {
//             Route::get('/applied-jobs',  [UserJobController::class, "appliedJobs"])->name('user.job.appliedJobs');
//             Route::get('/saved-jobs',  [UserJobController::class, "savedJobs"])->name('user.job.savedJobs');
//             Route::get('/',  [UserJobController::class, "index"])->name('user.job.index');
//             // Route::get('/search',  [UserJobController::class, "search"])->name('user.job.search');
//             // Route::post('/search',  [UserJobController::class, "doSearch"])->name('user.job.doSearch'); 
//             Route::get('/apply/{id}',  [UserJobController::class, "apply"])->name('user.job.apply');
//             Route::get('/unapply/{id}',  [UserJobController::class, "unapply"])->name('user.job.unapply');
//             // Route::get('/cancel-applied-job/{id}',  [UserJobController::class, "cancelAppliedJob"])->name('user.job.cancelAppliedJob');
//             Route::get('/save-job/{id}',  [UserJobController::class, "saveJob"])->name('user.job.saveJob');
//             Route::get('/unsave-job/{id}',  [UserJobController::class, "unsaveJob"])->name('user.job.unsaveJob');
//             // show job 
//             Route::get('/company/{id}',  [UserJobController::class, "jobByCompany"])->name('user.job.jobByCompany');
//             Route::get('/location/{id}',  [UserJobController::class, "jobByLocation"])->name('user.job.jobByLocation');
//             Route::get('/qualification/{id}',  [UserJobController::class, "jobByQualification"])->name('user.job.jobByQualification');
//             Route::get('/profile-category/{id}',  [UserJobController::class, "jobByProfileCategory"])->name('user.job.jobByProfileCategory');
//             Route::get('/sub-profile/{id}',  [UserJobController::class, "jobBySubProfile"])->name('user.job.jobBySubProfile');
//             Route::get('/{id}',  [UserJobController::class, "show"])->name('user.job.show');
//         });

//         // Route::get('/company/{id}',  [UserJobController::class, "jobByCompany"])->name('user.job.jobByCompany');
//         // Route::get('/location/{id}',  [UserJobController::class, "jobByLocation"])->name('user.job.jobByLocation');
//         // Route::get('/qualification/{id}',  [UserJobController::class, "jobByQualification"])->name('user.job.jobByQualification');
//         // Route::get('/profile-category/{id}',  [UserJobController::class, "jobByProfileCategory"])->name('user.job.jobByProfileCategory');
//         // Route::get('/sub-profile/{id}',  [UserJobController::class, "jobBySubProfile"])->name('user.job.jobBySubProfile');
//         // Route::get('/{id}',  [UserJobController::class, "show"])->name('user.job.show');

//         // posts comments likes
//         Route::prefix('post')->group(function () {
//             Route::get('/',  [UserPostsController::class, "indexPost"])->name('user.post.index');
//             Route::get('/all',  [UserPostsController::class, "allPost"])->name('user.post.all');
//             Route::get('/create',  [UserPostsController::class, "createPost"])->name('user.post.create');
//             Route::post('/store',  [UserPostsController::class, "storePost"])->name('user.post.store');
//             Route::get('/{id}',  [UserPostsController::class, "showPost"])->name('user.post.show');
//             Route::get('/edit/{id}',  [UserPostsController::class, "editPost"])->name('user.post.edit');
//             Route::post('/update/{id}',  [UserPostsController::class, "updatePost"])->name('user.post.update');
//             Route::get('/delete/{id}',  [UserPostsController::class, "deletePost"])->name('user.post.delete');
//             Route::get('/like/{id}',  [UserPostsController::class, "likePost"])->name('user.post.like');
//             Route::get('/unlike/{id}',  [UserPostsController::class, "unlikePost"])->name('user.post.unlike');

//             // comments profix
//             Route::prefix('comment')->group(function () {
//                 Route::get('/{id}',  [UserPostsController::class, "commentPostIndex"])->name('user.post.commentIndex');  // comment index page
//                 Route::get('/{id}/create',  [UserPostsController::class, "commentPostCreate"])->name('user.post.commentCreate');  // comment create page
//                 Route::post('/{id}/store',  [UserPostsController::class, "commentPostStore"])->name('user.post.commentStore');  // comment store page
//                 Route::get('/{id}/edit/{comment_id}',  [UserPostsController::class, "commentPostEdit"])->name('user.post.commentEdit');  // comment edit page
//                 Route::post('/{id}/update/{comment_id}',  [UserPostsController::class, "commentPostUpdate"])->name('user.post.commentUpdate');  // comment update page
//                 Route::get('/{id}/delete/{comment_id}',  [UserPostsController::class, "commentPostDelete"])->name('user.post.commentDelete');  // comment delete page
//                 Route::get('/{id}/like/{comment_id}',  [UserPostsController::class, "commentPostLike"])->name('user.post.commentLike');  // comment like page
//                 Route::get('/{id}/unlike/{comment_id}',  [UserPostsController::class, "commentPostUnlike"])->name('user.post.commentUnlike');  // comment unlike page
//             });
//         });
//     });
// });
