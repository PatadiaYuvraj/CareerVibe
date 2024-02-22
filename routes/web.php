<?php

// Admin 
use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\CompanyController as AdminCompanyController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\JobController as AdminJobController;
use App\Http\Controllers\Admin\LocationController as AdminLocationController;
use App\Http\Controllers\Admin\QualificationController as AdminQualificationController;
use App\Http\Controllers\Admin\SubProfileController as AdminSubProfileController;
use App\Http\Controllers\Admin\ProfileCategoryController as AdminProfileCategoryController;

// Company
use App\Http\Controllers\Company\AuthController as CompanyAuthController;
use App\Http\Controllers\Company\NotificationsController as CompanyNotificationsController;
use App\Http\Controllers\Company\JobController as CompanyJobController;
use App\Http\Controllers\Company\FollowsController as CompanyFollowsController;
use App\Http\Controllers\Company\PostsController as CompanyPostsController;

// User
use App\Http\Controllers\User\AuthController as UserAuthController;
use App\Http\Controllers\User\CompanyController as UserCompanyController;
use App\Http\Controllers\User\JobController as UserJobController;
use App\Http\Controllers\User\FollowsController as UserFollowsController;
use App\Http\Controllers\User\NotificationsController as UserNotificationsController;
use App\Http\Controllers\User\PostsController as UserPostsController;

// Admin Company
use App\Http\Controllers\Admin_Company\AuthController as AdminCompanyAuthController;
use App\Http\Controllers\Admin_Company\NotificationsController as AdminCompanyNotificationsController;
use App\Http\Controllers\Admin_Company\JobController as AdminCompanyJobController;
use App\Http\Controllers\Admin_Company\FollowsController as AdminCompanyFollowsController;
use App\Http\Controllers\Admin_Company\PostsController as AdminCompanyPostsController;

// Admin User
use App\Http\Controllers\Admin_User\CompanyController as AdminUserCompanyController;
use App\Http\Controllers\Admin_User\JobController as AdminUserJobController;
use App\Http\Controllers\Admin_User\AuthController as AdminUserAuthController;
use App\Http\Controllers\Admin_User\FollowsController as AdminUserFollowsController;
use App\Http\Controllers\Admin_User\NotificationsController as AdminUserNotificationsController;
use App\Http\Controllers\Admin_User\PostsController as AdminUserPostsController;

use App\Http\Controllers\TestController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::group(['middleware' => "isGuest"], function () {

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

    // Admin User Routes
    Route::prefix('/admin_user')->group(function () {
        Route::get('/login',  [AdminUserAuthController::class, "login"])->name('admin_user.login');
        Route::get('/register', [AdminUserAuthController::class, "register"])->name('admin_user.register');
        Route::post('/login', [AdminUserAuthController::class, "doLogin"])->name('admin_user.doLogin');
        Route::post('/register', [AdminUserAuthController::class, "doRegister"])->name('admin_user.doRegister');
        Route::get('/verify-email/{token}',  [AdminUserAuthController::class, "verifyEmail"])->name('admin_user.verifyEmail');
        Route::get('/resend-verification-email',  [AdminUserAuthController::class, "resendVerificationEmail"])->name('admin_user.resendVerificationEmail');
        Route::get('/send-verification-email',  [AdminUserAuthController::class, "sendVerificationEmail"])->name('admin_user.sendVerificationEmail');
        Route::get('/forgot-password',  [AdminUserAuthController::class, "forgotPassword"])->name('admin_user.forgotPassword');
        Route::post('/forgot-password',  [AdminUserAuthController::class, "doForgotPassword"])->name('admin_user.doForgotPassword');
        Route::get('/reset-password/{token}',  [AdminUserAuthController::class, "resetPassword"])->name('admin_user.resetPassword');
        Route::post('/reset-password/{token}',  [AdminUserAuthController::class, "doResetPassword"])->name('admin_user.doResetPassword');
    });

    // Admin Company Routes
    Route::prefix('/admin_company')->group(function () {
        Route::get('/login',  [AdminCompanyAuthController::class, "login"])->name('admin_company.login');
        Route::get('/register', [AdminCompanyAuthController::class, "register"])->name('admin_company.register');
        Route::post('/login', [AdminCompanyAuthController::class, "doLogin"])->name('admin_company.doLogin');
        Route::post('/register', [AdminCompanyAuthController::class, "doRegister"])->name('admin_company.doRegister');
        Route::get('/verify-email/{token}',  [AdminCompanyAuthController::class, "verifyEmail"])->name('admin_company.verifyEmail');
        Route::get('/resend-verification-email',  [AdminCompanyAuthController::class, "resendVerificationEmail"])->name('admin_company.resendVerificationEmail');
        Route::get('/send-verification-email',  [AdminCompanyAuthController::class, "sendVerificationEmail"])->name('admin_company.sendVerificationEmail');
        Route::get('/forgot-password',  [AdminCompanyAuthController::class, "forgotPassword"])->name('admin_company.forgotPassword');
        Route::post('/forgot-password',  [AdminCompanyAuthController::class, "doForgotPassword"])->name('admin_company.doForgotPassword');
        Route::get('/reset-password/{token}',  [AdminCompanyAuthController::class, "resetPassword"])->name('admin_company.resetPassword');
        Route::post('/reset-password/{token}',  [AdminCompanyAuthController::class, "doResetPassword"])->name('admin_company.doResetPassword');
    });
});

// Front Company Routes
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

        // Route::get('/followers',  [CompanyFollowsController::class, "followers"])->name('company.followers');
        // Route::get('/all-users',  [CompanyFollowsController::class, "allUsers"])->name('company.allUsers');
        // Route::get('/remove-follower/{id}',  [CompanyFollowsController::class, "removeFollower"])->name('company.removeFollower');

        // notifications
        // Route::prefix('notifications')->group(function () {
        //     Route::get('/',  [CompanyNotificationsController::class, "notifications"])->name('company.notifications');
        //     Route::get('/mark-all-as-read',  [CompanyNotificationsController::class, "markAllAsRead"])->name('company.notification.readAll');
        //     Route::get('/mark-as-read/{id}',  [CompanyNotificationsController::class, "markAsRead"])->name('company.notification.read');
        //     Route::get('/mark-as-unread/{id}',  [CompanyNotificationsController::class, "markAsUnread"])->name('company.notification.unread');
        //     Route::get('/delete-notification/{id}',  [CompanyNotificationsController::class, "deleteNotification"])->name('company.notification.delete');
        //     Route::get('/delete-all-notification',  [CompanyNotificationsController::class, "deleteAllNotification"])->name('company.notification.deleteAll');
        // });

        // posts comments likes
        // Route::prefix('post')->group(function () {
        //     Route::get('/',  [CompanyPostsController::class, "indexPost"])->name('company.post.index');
        //     Route::get('/all',  [CompanyPostsController::class, "allPost"])->name('company.post.all');
        //     Route::get('/create',  [CompanyPostsController::class, "createPost"])->name('company.post.create');
        //     Route::post('/store',  [CompanyPostsController::class, "storePost"])->name('company.post.store');
        //     Route::get('/{id}',  [CompanyPostsController::class, "showPost"])->name('company.post.show');
        //     Route::get('/edit/{id}',  [CompanyPostsController::class, "editPost"])->name('company.post.edit');
        //     Route::post('/update/{id}',  [CompanyPostsController::class, "updatePost"])->name('company.post.update');
        //     Route::get('/delete/{id}',  [CompanyPostsController::class, "deletePost"])->name('company.post.delete');
        //     Route::get('/like/{id}',  [CompanyPostsController::class, "likePost"])->name('company.post.like');
        //     Route::get('/unlike/{id}',  [CompanyPostsController::class, "unlikePost"])->name('company.post.unlike');

        //     // comments profix
        //     Route::prefix('comment')->group(function () {
        //         Route::get('/{id}',  [CompanyPostsController::class, "commentPostIndex"])->name('company.post.commentIndex');  // comment index page
        //         Route::get('/{id}/create',  [CompanyPostsController::class, "commentPostCreate"])->name('company.post.commentCreate');  // comment create page
        //         Route::post('/{id}/store',  [CompanyPostsController::class, "commentPostStore"])->name('company.post.commentStore');  // comment store page
        //         Route::get('/{id}/edit/{comment_id}',  [CompanyPostsController::class, "commentPostEdit"])->name('company.post.commentEdit');  // comment edit page
        //         Route::post('/{id}/update/{comment_id}',  [CompanyPostsController::class, "commentPostUpdate"])->name('company.post.commentUpdate');  // comment update page
        //         Route::get('/{id}/delete/{comment_id}',  [CompanyPostsController::class, "commentPostDelete"])->name('company.post.commentDelete');  // comment delete page
        //         Route::get('/{id}/like/{comment_id}',  [CompanyPostsController::class, "commentPostLike"])->name('company.post.commentLike');  // comment like page
        //         Route::get('/{id}/unlike/{comment_id}',  [CompanyPostsController::class, "commentPostUnlike"])->name('company.post.commentUnlike');  // comment unlike page
        //     });
        // });

        // Route::prefix('job')->group(function () {
        //     Route::get('/create',  [CompanyJobController::class, "create"])->name('company.job.create');
        //     Route::post('/store',  [CompanyJobController::class, "store"])->name('company.job.store');
        //     Route::get('/',  [CompanyJobController::class, "index"])->name('company.job.index');
        //     Route::get('/{id}',  [CompanyJobController::class, "show"])->name('company.job.show');
        //     Route::get('/edit/{id}',  [CompanyJobController::class, "edit"])->name('company.job.edit');
        //     Route::post('/update/{id}',  [CompanyJobController::class, "update"])->name('company.job.update');
        //     Route::get('/delete/{id}',  [CompanyJobController::class, "delete"])->name('company.job.delete');
        //     Route::get('/toggle-featured/{id}/{is_featured}',  [CompanyJobController::class, "toggleFeatured"])->name('company.job.toggleFeatured');
        //     Route::get('/toggle-active/{id}/{is_active}',  [CompanyJobController::class, "toggleActive"])->name('company.job.toggleActive');
        // });
    });
});

// Front User Routes
Route::group(['middleware' => "isUser"], function () {
    Route::prefix('/user')->group(function () {


        Route::get('search', function (Request $request) {

            return redirect()->route('user.dashboard')->with('info', 'Search is not implemented yet');
        })->name('user.search');
        Route::post('search', function (Request $request) {

            return redirect()->route('user.dashboard')->with('info', 'Search is not implemented yet');
        })->name('user.doSearch');


        Route::get('/dashboard',  [UserAuthController::class, "dashboard"])->name('user.dashboard');
        Route::get('/profile',  [UserAuthController::class, "profile"])->name('user.profile');
        Route::get('/logout',  [UserAuthController::class, "logout"])->name('user.logout');
        Route::get('/edit-profile',  [UserAuthController::class, "editProfile"])->name('user.editProfile');
        Route::post('/update-profile',  [UserAuthController::class, "updateProfile"])->name('user.updateProfile');
        Route::get('/change-password',  [UserAuthController::class, "changePassword"])->name('user.changePassword');
        Route::post('/change-password',  [UserAuthController::class, "doChangePassword"])->name('user.doChangePassword');
        Route::get('/edit-profile-image',  [UserAuthController::class, "editProfileImage"])->name('user.editProfileImage');
        Route::post('/update-profile-image',  [UserAuthController::class, "updateProfileImage"])->name('user.updateProfileImage');
        Route::post('/delete-profile-image',  [UserAuthController::class, "deleteProfileImage"])->name('user.deleteProfileImage');
        Route::get('/edit-resume-pdf',  [UserAuthController::class, "editResumePdf"])->name('user.editResumePdf');
        Route::post('/update-resume-pdf',  [UserAuthController::class, "updateResumePdf"])->name('user.updateResumePdf');
        Route::get('/delete-resume-pdf',  [UserAuthController::class, "deleteResumePdf"])->name('user.deleteResumePdf');

        // notification
        // Route::prefix('notifications')->group(function () {
        //     Route::get('/',  [UserNotificationsController::class, "notifications"])->name('user.notifications');
        //     Route::get('/mark-all-as-read',  [UserNotificationsController::class, "markAllAsRead"])->name('user.notification.readAll');
        //     Route::get('/mark-as-read/{id}',  [UserNotificationsController::class, "markAsRead"])->name('user.notification.read');
        //     Route::get('/mark-as-unread/{id}',  [UserNotificationsController::class, "markAsUnread"])->name('user.notification.unread');
        //     Route::get('/delete-notification/{id}',  [UserNotificationsController::class, "deleteNotification"])->name('user.notification.delete');
        //     Route::get('/delete-all-notification',  [UserNotificationsController::class, "deleteAllNotification"])->name('user.notification.deleteAll');
        // });

        // Route::get('/follow/{id}',  [UserFollowsController::class, "follow"])->name('user.follow');
        // Route::get('/unfollow/{id}',  [UserFollowsController::class, "unfollow"])->name('user.unfollow');
        // Route::get('/followers',  [UserFollowsController::class, "followers"])->name('user.followers');
        // Route::get('/following',  [UserFollowsController::class, "following"])->name('user.following');
        // Route::get('/all-users',  [UserFollowsController::class, "allUsers"])->name('user.allUsers');
        // Route::get('/remove-follower/{id}',  [UserFollowsController::class, "removeFollower"])->name('user.removeFollower');
        Route::prefix('company')->group(function () {
            Route::get('/followers/{id}',  [UserFollowsController::class, "followers"])->name('user.company.followers');
            Route::get('/follow/{id}',  [UserFollowsController::class, "followCompany"])->name('user.company.follow');
            Route::get('/unfollow/{id}',  [UserFollowsController::class, "unfollowCompany"])->name('user.company.unfollow');
        });
        //  all Company
        Route::prefix('company')->group(function () {
            Route::get('/',  [UserCompanyController::class, "index"])->name('user.company.index');
            Route::get('/{id}',  [UserCompanyController::class, "show"])->name('user.company.show');
        });
        Route::prefix('job')->group(function () {
            Route::get('/',  [UserJobController::class, "index"])->name('user.job.index');
            // Route::get('/getAllJobs',  [UserJobController::class, "getAllJobs"])->name('user.job.getAllJobs');

            Route::get('/applied-jobs',  [UserJobController::class, "appliedJobs"])->name('user.job.appliedJobs');
            Route::get('/saved-jobs',  [UserJobController::class, "savedJobs"])->name('user.job.savedJobs');
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

        // Route::get('/company/{id}',  [UserJobController::class, "jobByCompany"])->name('user.job.jobByCompany');
        // Route::get('/location/{id}',  [UserJobController::class, "jobByLocation"])->name('user.job.jobByLocation');
        // Route::get('/qualification/{id}',  [UserJobController::class, "jobByQualification"])->name('user.job.jobByQualification');
        // Route::get('/profile-category/{id}',  [UserJobController::class, "jobByProfileCategory"])->name('user.job.jobByProfileCategory');
        // Route::get('/sub-profile/{id}',  [UserJobController::class, "jobBySubProfile"])->name('user.job.jobBySubProfile');
        // Route::get('/{id}',  [UserJobController::class, "show"])->name('user.job.show');

        // posts comments likes
        // Route::prefix('post')->group(function () {
        //     Route::get('/',  [UserPostsController::class, "indexPost"])->name('user.post.index');
        //     Route::get('/all',  [UserPostsController::class, "allPost"])->name('user.post.all');
        //     Route::get('/create',  [UserPostsController::class, "createPost"])->name('user.post.create');
        //     Route::post('/store',  [UserPostsController::class, "storePost"])->name('user.post.store');
        //     Route::get('/{id}',  [UserPostsController::class, "showPost"])->name('user.post.show');
        //     Route::get('/edit/{id}',  [UserPostsController::class, "editPost"])->name('user.post.edit');
        //     Route::post('/update/{id}',  [UserPostsController::class, "updatePost"])->name('user.post.update');
        //     Route::get('/delete/{id}',  [UserPostsController::class, "deletePost"])->name('user.post.delete');
        //     Route::get('/like/{id}',  [UserPostsController::class, "likePost"])->name('user.post.like');
        //     Route::get('/unlike/{id}',  [UserPostsController::class, "unlikePost"])->name('user.post.unlike');

        //     // comments profix
        //     Route::prefix('comment')->group(function () {
        //         Route::get('/{id}',  [UserPostsController::class, "commentPostIndex"])->name('user.post.commentIndex');  // comment index page
        //         Route::get('/{id}/create',  [UserPostsController::class, "commentPostCreate"])->name('user.post.commentCreate');  // comment create page
        //         Route::post('/{id}/store',  [UserPostsController::class, "commentPostStore"])->name('user.post.commentStore');  // comment store page
        //         Route::get('/{id}/edit/{comment_id}',  [UserPostsController::class, "commentPostEdit"])->name('user.post.commentEdit');  // comment edit page
        //         Route::post('/{id}/update/{comment_id}',  [UserPostsController::class, "commentPostUpdate"])->name('user.post.commentUpdate');  // comment update page
        //         Route::get('/{id}/delete/{comment_id}',  [UserPostsController::class, "commentPostDelete"])->name('user.post.commentDelete');  // comment delete page
        //         Route::get('/{id}/like/{comment_id}',  [UserPostsController::class, "commentPostLike"])->name('user.post.commentLike');  // comment like page
        //         Route::get('/{id}/unlike/{comment_id}',  [UserPostsController::class, "commentPostUnlike"])->name('user.post.commentUnlike');  // comment unlike page
        //     });
        // });
    });
});

// Admin Routes
Route::group(['middleware' => "isAdmin"], function () {
    Route::prefix('/admin')->group(function () {

        Route::get('search', function (Request $request) {
            return redirect()->back()->with('info', 'Search is not implemented yet');
        })->name('admin.search');
        Route::post('search', function (Request $request) {
            return redirect()->back()->with('info', 'Search is not implemented yet');
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
            Route::get('/livewire',  [AdminUserController::class, "livewire"])->name('admin.user.livewire');
            Route::post('/update-profile-image/{id}',  [AdminUserController::class, "updateUserProfileImage"])->name('admin.user.updateProfileImage');
            Route::post('/update-resume-pdf/{id}',  [AdminUserController::class, "updateUserResume"])->name('admin.user.updateResumePdf');
            Route::delete('/delete-profile-image/{id}',  [AdminUserController::class, "deleteUserProfileImage"])->name('admin.user.deleteProfileImage');
            Route::delete('/delete-resume-pdf/{id}',  [AdminUserController::class, "deleteUserResume"])->name('admin.user.deleteResumePdf');
        });

        Route::resource('user', AdminUserController::class)->names([
            'create' => 'admin.user.create',
            'store' => 'admin.user.store',
            'index' => 'admin.user.index',
            'show' => 'admin.user.show',
            'edit' => 'admin.user.edit',
            'update' => 'admin.user.update',
            'destroy' => 'admin.user.delete',
        ]);



        Route::prefix('company')->group(function () {
            Route::get('toggle-verified/{id}/{is_verified}',  [AdminCompanyController::class, "toggleVerified"])->name('admin.company.toggleVerified');
            Route::post('store-profile-image/{id}',  [AdminCompanyController::class, "storeProfileImage"])->name('admin.company.storeProfileImage');
            Route::post('update-profile-image/{id}',  [AdminCompanyController::class, "updateCompanyProfileImage"])->name('admin.company.updateProfileImage');
            Route::post('delete-profile-image/{id}',  [AdminCompanyController::class, "deleteProfileImage"])->name('admin.company.deleteProfileImage');
        });


        Route::resource('company', AdminCompanyController::class)->names([
            'create' => 'admin.company.create',
            'store' => 'admin.company.store',
            'index' => 'admin.company.index',
            'show' => 'admin.company.show',
            'edit' => 'admin.company.edit',
            'update' => 'admin.company.update',
            'destroy' => 'admin.company.delete',
        ]);


        // Route::prefix('job')->group(function () {
        //     Route::get('/',  [AdminJobController::class, "index"])->name('admin.job.index');
        //     Route::get('/{id}',  [AdminJobController::class, "show"])->name('admin.job.show');
        //     Route::get('/edit/{id}',  [AdminJobController::class, "edit"])->name('admin.job.edit');
        //     Route::post('/update/{id}',  [AdminJobController::class, "update"])->name('admin.job.update');
        //     Route::get('/delete/{id}',  [AdminJobController::class, "delete"])->name('admin.job.delete');
        //     Route::get('/toggle-verified/{id}/{is_verified}',  [AdminJobController::class, "toggleVerified"])->name('admin.job.toggleVerified');
        //     Route::get('/toggle-featured/{id}/{is_featured}',  [AdminJobController::class, "toggleFeatured"])->name('admin.job.toggleFeatured');
        //     Route::get('/toggle-active/{id}/{is_active}',  [AdminJobController::class, "toggleActive"])->name('admin.job.toggleActive');
        // });

        // make resource route for job


        Route::post('job/store/{id}',  [AdminJobController::class, "store"])->name('admin.job.store'); // id is company id
        Route::get('job/create/{id}',  [AdminJobController::class, "create"])->name('admin.job.create'); // id is company id
        Route::get('job/toggle-verified/{id}/{is_verified}',  [AdminJobController::class, "toggleVerified"])->name('admin.job.toggleVerified');
        Route::get('job/toggle-featured/{id}/{is_featured}',  [AdminJobController::class, "toggleFeatured"])->name('admin.job.toggleFeatured');
        Route::get('job/toggle-active/{id}/{is_active}',  [AdminJobController::class, "toggleActive"])->name('admin.job.toggleActive');

        Route::resource('job', AdminJobController::class)->names([
            // 'create' => 'admin.job.create',
            // 'store' => 'admin.job.store',
            'index' => 'admin.job.index',
            'show' => 'admin.job.show',
            'edit' => 'admin.job.edit',
            'update' => 'admin.job.update',
            'destroy' => 'admin.job.delete',
        ]);



        // Route::prefix('profile-category')->group(function () {
        //     Route::get('/livewire',  [AdminProfileCategoryController::class, "livewire"])->name('admin.profile-category.livewire');
        //     Route::get('/create',  [AdminProfileCategoryController::class, "create"])->name('admin.profile-category.create');
        //     Route::post('/store',  [AdminProfileCategoryController::class, "store"])->name('admin.profile-category.store');
        //     Route::get('/',  [AdminProfileCategoryController::class, "index"])->name('admin.profile-category.index');
        //     Route::get('/{id}',  [AdminProfileCategoryController::class, "show"])->name('admin.profile-category.show');
        //     Route::get('/edit/{id}',  [AdminProfileCategoryController::class, "edit"])->name('admin.profile-category.edit');
        //     Route::post('/update/{id}',  [AdminProfileCategoryController::class, "update"])->name('admin.profile-category.update');
        //     Route::get('/delete/{id}',  [AdminProfileCategoryController::class, "delete"])->name('admin.profile-category.delete');
        // });
        Route::get('profile-category/livewire',  [AdminProfileCategoryController::class, "livewire"])->name('admin.profile-category.livewire');

        Route::resource('profile-category', AdminProfileCategoryController::class)->names([
            'create' => 'admin.profile-category.create',
            'store' => 'admin.profile-category.store',
            'index' => 'admin.profile-category.index',
            'show' => 'admin.profile-category.show',
            'edit' => 'admin.profile-category.edit',
            'update' => 'admin.profile-category.update',
            'destroy' => 'admin.profile-category.delete',
        ]);

        // Route::prefix('sub-profile')->group(function () {
        //     Route::get('/livewire',  [AdminSubProfileController::class, "livewire"])->name('admin.sub-profile.livewire');
        //     Route::get('/create',  [AdminSubProfileController::class, "create"])->name('admin.sub-profile.create');
        //     Route::post('/store',  [AdminSubProfileController::class, "store"])->name('admin.sub-profile.store');
        //     Route::get('/',  [AdminSubProfileController::class, "index"])->name('admin.sub-profile.index');
        //     Route::get('/{id}',  [AdminSubProfileController::class, "show"])->name('admin.sub-profile.show');
        //     Route::get('/edit/{id}',  [AdminSubProfileController::class, "edit"])->name('admin.sub-profile.edit');
        //     Route::post('/update/{id}',  [AdminSubProfileController::class, "update"])->name('admin.sub-profile.update');
        //     Route::get('/delete/{id}',  [AdminSubProfileController::class, "delete"])->name('admin.sub-profile.delete');
        // });

        Route::get('sub-profile/livewire',  [AdminSubProfileController::class, "livewire"])->name('admin.sub-profile.livewire');

        Route::resource('sub-profile', AdminSubProfileController::class)->names([
            'create' => 'admin.sub-profile.create',
            'store' => 'admin.sub-profile.store',
            'index' => 'admin.sub-profile.index',
            'show' => 'admin.sub-profile.show',
            'edit' => 'admin.sub-profile.edit',
            'update' => 'admin.sub-profile.update',
            'destroy' => 'admin.sub-profile.delete',
        ]);



        Route::prefix('location')->group(function () {
            Route::get('/livewire',  [AdminLocationController::class, "livewire"])->name('admin.location.livewire');
            Route::get('/getAll',  [AdminLocationController::class, "getAll"])->name('admin.location.getAll');
            Route::post('/store',  [AdminLocationController::class, "store"])->name('admin.location.store');
            Route::get('/',  [AdminLocationController::class, "index"])->name('admin.location.index');
            Route::get('/show',  [AdminLocationController::class, "show"])->name('admin.location.show');
            Route::get('/edit',  [AdminLocationController::class, "edit"])->name('admin.location.edit');
            Route::post('/update',  [AdminLocationController::class, "update"])->name('admin.location.update');
            Route::get('/delete',  [AdminLocationController::class, "delete"])->name('admin.location.delete');
        });

        Route::prefix('qualification')->group(function () {
            Route::get('/livewire',  [AdminQualificationController::class, "livewire"])->name('admin.qualification.livewire');
            Route::post('/store',  [AdminQualificationController::class, "store"])->name('admin.qualification.store');
            Route::get('/',  [AdminQualificationController::class, "index"])->name('admin.qualification.index');
            Route::get('/getAll',  [AdminQualificationController::class, "getAll"])->name('admin.qualification.getAll');
            Route::get('/show',  [AdminQualificationController::class, "show"])->name('admin.qualification.show');
            Route::get('/edit',  [AdminQualificationController::class, "edit"])->name('admin.qualification.edit');
            Route::post('/update',  [AdminQualificationController::class, "update"])->name('admin.qualification.update');
            Route::get('/delete',  [AdminQualificationController::class, "delete"])->name('admin.qualification.delete');
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

// Admin Company Routes
Route::group(['middleware' => "isCompany"], function () {
    Route::prefix('/admin_company')->group(function () {
        Route::get('/edit-profile',  [AdminCompanyAuthController::class, "editProfile"])->name('admin_company.editProfile');
        Route::post('/update-profile',  [AdminCompanyAuthController::class, "updateProfile"])->name('admin_company.updateProfile');
        Route::get('/change-password',  [AdminCompanyAuthController::class, "changePassword"])->name('admin_company.changePassword');
        Route::post('/change-password',  [AdminCompanyAuthController::class, "doChangePassword"])->name('admin_company.doChangePassword');
        Route::get('/edit-profile-image',  [AdminCompanyAuthController::class, "editProfileImage"])->name('admin_company.editProfileImage');
        Route::post('/update-profile-image',  [AdminCompanyAuthController::class, "updateProfileImage"])->name('admin_company.updateProfileImage');
        Route::post('/delete-profile-image',  [AdminCompanyAuthController::class, "deleteProfileImage"])->name('admin_company.deleteProfileImage');
        Route::get('/dashboard',  [AdminCompanyAuthController::class, "dashboard"])->name('admin_company.dashboard');
        Route::get('/logout',  [AdminCompanyAuthController::class, "logout"])->name('admin_company.logout');

        Route::get('/followers',  [AdminCompanyFollowsController::class, "followers"])->name('admin_company.followers');
        Route::get('/all-users',  [AdminCompanyFollowsController::class, "allUsers"])->name('admin_company.allUsers');
        Route::get('/remove-follower/{id}',  [AdminCompanyFollowsController::class, "removeFollower"])->name('admin_company.removeFollower');

        // notifications
        Route::prefix('notifications')->group(function () {
            Route::get('/',  [AdminCompanyNotificationsController::class, "notifications"])->name('admin_company.notifications');
            Route::get('/mark-all-as-read',  [AdminCompanyNotificationsController::class, "markAllAsRead"])->name('admin_company.notification.readAll');
            Route::get('/mark-as-read/{id}',  [AdminCompanyNotificationsController::class, "markAsRead"])->name('admin_company.notification.read');
            Route::get('/mark-as-unread/{id}',  [AdminCompanyNotificationsController::class, "markAsUnread"])->name('admin_company.notification.unread');
            Route::get('/delete-notification/{id}',  [AdminCompanyNotificationsController::class, "deleteNotification"])->name('admin_company.notification.delete');
            Route::get('/delete-all-notification',  [AdminCompanyNotificationsController::class, "deleteAllNotification"])->name('admin_company.notification.deleteAll');
        });

        // posts comments likes
        Route::prefix('post')->group(function () {
            Route::get('/',  [AdminCompanyPostsController::class, "indexPost"])->name('admin_company.post.index');
            Route::get('/all',  [AdminCompanyPostsController::class, "allPost"])->name('admin_company.post.all');
            Route::get('/create',  [AdminCompanyPostsController::class, "createPost"])->name('admin_company.post.create');
            Route::post('/store',  [AdminCompanyPostsController::class, "storePost"])->name('admin_company.post.store');
            Route::get('/{id}',  [AdminCompanyPostsController::class, "showPost"])->name('admin_company.post.show');
            Route::get('/edit/{id}',  [AdminCompanyPostsController::class, "editPost"])->name('admin_company.post.edit');
            Route::post('/update/{id}',  [AdminCompanyPostsController::class, "updatePost"])->name('admin_company.post.update');
            Route::get('/delete/{id}',  [AdminCompanyPostsController::class, "deletePost"])->name('admin_company.post.delete');
            Route::get('/like/{id}',  [AdminCompanyPostsController::class, "likePost"])->name('admin_company.post.like');
            Route::get('/unlike/{id}',  [AdminCompanyPostsController::class, "unlikePost"])->name('admin_company.post.unlike');

            // comments profix
            Route::prefix('comment')->group(function () {
                Route::get('/{id}',  [AdminCompanyPostsController::class, "commentPostIndex"])->name('admin_company.post.commentIndex');  // comment index page
                Route::get('/{id}/create',  [AdminCompanyPostsController::class, "commentPostCreate"])->name('admin_company.post.commentCreate');  // comment create page
                Route::post('/{id}/store',  [AdminCompanyPostsController::class, "commentPostStore"])->name('admin_company.post.commentStore');  // comment store page
                Route::get('/{id}/edit/{comment_id}',  [AdminCompanyPostsController::class, "commentPostEdit"])->name('admin_company.post.commentEdit');  // comment edit page
                Route::post('/{id}/update/{comment_id}',  [AdminCompanyPostsController::class, "commentPostUpdate"])->name('admin_company.post.commentUpdate');  // comment update page
                Route::get('/{id}/delete/{comment_id}',  [AdminCompanyPostsController::class, "commentPostDelete"])->name('admin_company.post.commentDelete');  // comment delete page
                Route::get('/{id}/like/{comment_id}',  [AdminCompanyPostsController::class, "commentPostLike"])->name('admin_company.post.commentLike');  // comment like page
                Route::get('/{id}/unlike/{comment_id}',  [AdminCompanyPostsController::class, "commentPostUnlike"])->name('admin_company.post.commentUnlike');  // comment unlike page
            });
        });

        Route::prefix('job')->group(function () {
            Route::get('/create',  [AdminCompanyJobController::class, "create"])->name('admin_company.job.create');
            Route::post('/store',  [AdminCompanyJobController::class, "store"])->name('admin_company.job.store');
            Route::get('/',  [AdminCompanyJobController::class, "index"])->name('admin_company.job.index');
            Route::get('/{id}',  [AdminCompanyJobController::class, "show"])->name('admin_company.job.show');
            Route::get('/edit/{id}',  [AdminCompanyJobController::class, "edit"])->name('admin_company.job.edit');
            Route::post('/update/{id}',  [AdminCompanyJobController::class, "update"])->name('admin_company.job.update');
            Route::get('/delete/{id}',  [AdminCompanyJobController::class, "delete"])->name('admin_company.job.delete');
            Route::get('/toggle-featured/{id}/{is_featured}',  [AdminCompanyJobController::class, "toggleFeatured"])->name('admin_company.job.toggleFeatured');
            Route::get('/toggle-active/{id}/{is_active}',  [AdminCompanyJobController::class, "toggleActive"])->name('admin_company.job.toggleActive');
        });
    });
});

// Admin User Routes
Route::group(['middleware' => "isUser"], function () {
    Route::prefix('/admin_user')->group(function () {
        Route::get('search', function (Request $request) {

            return redirect()->route('user.dashboard')->with('info', 'Search is not implemented yet');
        })->name('admin_user.search');
        Route::post('search', function (Request $request) {

            return redirect()->route('user.dashboard')->with('info', 'Search is not implemented yet');
        })->name('admin_user.doSearch');


        Route::get('/dashboard',  [AdminUserAuthController::class, "dashboard"])->name('admin_user.dashboard');
        Route::get('/logout',  [AdminUserAuthController::class, "logout"])->name('admin_user.logout');
        Route::get('/edit-profile',  [AdminUserAuthController::class, "editProfile"])->name('admin_user.editProfile');
        Route::post('/update-profile',  [AdminUserAuthController::class, "updateProfile"])->name('admin_user.updateProfile');
        Route::get('/change-password',  [AdminUserAuthController::class, "changePassword"])->name('admin_user.changePassword');
        Route::post('/change-password',  [AdminUserAuthController::class, "doChangePassword"])->name('admin_user.doChangePassword');
        Route::get('/edit-profile-image',  [AdminUserAuthController::class, "editProfileImage"])->name('admin_user.editProfileImage');
        Route::post('/update-profile-image',  [AdminUserAuthController::class, "updateProfileImage"])->name('admin_user.updateProfileImage');
        Route::post('/delete-profile-image',  [AdminUserAuthController::class, "deleteProfileImage"])->name('admin_user.deleteProfileImage');
        Route::get('/edit-resume-pdf',  [AdminUserAuthController::class, "editResumePdf"])->name('admin_user.editResumePdf');
        Route::post('/update-resume-pdf',  [AdminUserAuthController::class, "updateResumePdf"])->name('admin_user.updateResumePdf');
        Route::get('/delete-resume-pdf',  [AdminUserAuthController::class, "deleteResumePdf"])->name('admin_user.deleteResumePdf');

        // notification
        Route::prefix('notifications')->group(function () {
            Route::get('/',  [AdminUserNotificationsController::class, "notifications"])->name('admin_user.notifications');
            Route::get('/mark-all-as-read',  [AdminUserNotificationsController::class, "markAllAsRead"])->name('admin_user.notification.readAll');
            Route::get('/mark-as-read/{id}',  [AdminUserNotificationsController::class, "markAsRead"])->name('admin_user.notification.read');
            Route::get('/mark-as-unread/{id}',  [AdminUserNotificationsController::class, "markAsUnread"])->name('admin_user.notification.unread');
            Route::get('/delete-notification/{id}',  [AdminUserNotificationsController::class, "deleteNotification"])->name('admin_user.notification.delete');
            Route::get('/delete-all-notification',  [AdminUserNotificationsController::class, "deleteAllNotification"])->name('admin_user.notification.deleteAll');
        });

        Route::get('/follow/{id}',  [AdminUserFollowsController::class, "follow"])->name('admin_user.follow');
        Route::get('/unfollow/{id}',  [AdminUserFollowsController::class, "unfollow"])->name('admin_user.unfollow');
        Route::get('/followers',  [AdminUserFollowsController::class, "followers"])->name('admin_user.followers');
        Route::get('/following',  [AdminUserFollowsController::class, "following"])->name('admin_user.following');
        Route::get('/all-users',  [AdminUserFollowsController::class, "allUsers"])->name('admin_user.allUsers');
        Route::get('/remove-follower/{id}',  [AdminUserFollowsController::class, "removeFollower"])->name('admin_user.removeFollower');
        Route::prefix('company')->group(function () {
            Route::get('/followers/{id}',  [AdminUserFollowsController::class, "followers"])->name('admin_user.company.followers');
            Route::get('/follow/{id}',  [AdminUserFollowsController::class, "followCompany"])->name('admin_user.company.follow');
            Route::get('/unfollow/{id}',  [AdminUserFollowsController::class, "unfollowCompany"])->name('admin_user.company.unfollow');
        });
        //  all Company
        Route::prefix('company')->group(function () {
            Route::get('/',  [AdminUserCompanyController::class, "index"])->name('admin_user.company.index');
            Route::get('/{id}',  [AdminUserCompanyController::class, "show"])->name('admin_user.company.show');
        });

        Route::prefix('job')->group(function () {
            Route::get('/getAllJobs',  [AdminUserJobController::class, "getAllJobs"])->name('admin_user.job.getAllJobs');

            Route::get('/applied-jobs',  [AdminUserJobController::class, "appliedJobs"])->name('admin_user.job.appliedJobs');
            Route::get('/saved-jobs',  [AdminUserJobController::class, "savedJobs"])->name('admin_user.job.savedJobs');
            Route::get('/',  [AdminUserJobController::class, "index"])->name('admin_user.job.index');
            // Route::get('/search',  [AdminUserJobController::class, "search"])->name('admin_user.job.search');
            // Route::post('/search',  [AdminUserJobController::class, "doSearch"])->name('admin_user.job.doSearch'); 
            Route::get('/apply/{id}',  [AdminUserJobController::class, "apply"])->name('admin_user.job.apply');
            Route::get('/unapply/{id}',  [AdminUserJobController::class, "unapply"])->name('admin_user.job.unapply');
            // Route::get('/cancel-applied-job/{id}',  [AdminUserJobController::class, "cancelAppliedJob"])->name('admin_user.job.cancelAppliedJob');
            Route::get('/save-job/{id}',  [AdminUserJobController::class, "saveJob"])->name('admin_user.job.saveJob');
            Route::get('/unsave-job/{id}',  [AdminUserJobController::class, "unsaveJob"])->name('admin_user.job.unsaveJob');
            // show job 
            Route::get('/company/{id}',  [AdminUserJobController::class, "jobByCompany"])->name('admin_user.job.jobByCompany');
            Route::get('/location/{id}',  [AdminUserJobController::class, "jobByLocation"])->name('admin_user.job.jobByLocation');
            Route::get('/qualification/{id}',  [AdminUserJobController::class, "jobByQualification"])->name('admin_user.job.jobByQualification');
            Route::get('/profile-category/{id}',  [AdminUserJobController::class, "jobByProfileCategory"])->name('admin_user.job.jobByProfileCategory');
            Route::get('/sub-profile/{id}',  [AdminUserJobController::class, "jobBySubProfile"])->name('admin_user.job.jobBySubProfile');
            Route::get('/{id}',  [AdminUserJobController::class, "show"])->name('admin_user.job.show');
        });

        // Route::get('/company/{id}',  [AdminUserJobController::class, "jobByCompany"])->name('admin_user.job.jobByCompany');
        // Route::get('/location/{id}',  [AdminUserJobController::class, "jobByLocation"])->name('admin_user.job.jobByLocation');
        // Route::get('/qualification/{id}',  [AdminUserJobController::class, "jobByQualification"])->name('admin_user.job.jobByQualification');
        // Route::get('/profile-category/{id}',  [AdminUserJobController::class, "jobByProfileCategory"])->name('admin_user.job.jobByProfileCategory');
        // Route::get('/sub-profile/{id}',  [AdminUserJobController::class, "jobBySubProfile"])->name('admin_user.job.jobBySubProfile');
        // Route::get('/{id}',  [AdminUserJobController::class, "show"])->name('admin_user.job.show');

        // posts comments likes
        Route::prefix('post')->group(function () {
            Route::get('/',  [AdminUserPostsController::class, "indexPost"])->name('admin_user.post.index');
            Route::get('/all',  [AdminUserPostsController::class, "allPost"])->name('admin_user.post.all');
            Route::get('/create',  [AdminUserPostsController::class, "createPost"])->name('admin_user.post.create');
            Route::post('/store',  [AdminUserPostsController::class, "storePost"])->name('admin_user.post.store');
            Route::get('/{id}',  [AdminUserPostsController::class, "showPost"])->name('admin_user.post.show');
            Route::get('/edit/{id}',  [AdminUserPostsController::class, "editPost"])->name('admin_user.post.edit');
            Route::post('/update/{id}',  [AdminUserPostsController::class, "updatePost"])->name('admin_user.post.update');
            Route::get('/delete/{id}',  [AdminUserPostsController::class, "deletePost"])->name('admin_user.post.delete');
            Route::get('/like/{id}',  [AdminUserPostsController::class, "likePost"])->name('admin_user.post.like');
            Route::get('/unlike/{id}',  [AdminUserPostsController::class, "unlikePost"])->name('admin_user.post.unlike');

            // comments profix
            Route::prefix('comment')->group(function () {
                Route::get('/{id}',  [AdminUserPostsController::class, "commentPostIndex"])->name('admin_user.post.commentIndex');  // comment index page
                Route::get('/{id}/create',  [AdminUserPostsController::class, "commentPostCreate"])->name('admin_user.post.commentCreate');  // comment create page
                Route::post('/{id}/store',  [AdminUserPostsController::class, "commentPostStore"])->name('admin_user.post.commentStore');  // comment store page
                Route::get('/{id}/edit/{comment_id}',  [AdminUserPostsController::class, "commentPostEdit"])->name('admin_user.post.commentEdit');  // comment edit page
                Route::post('/{id}/update/{comment_id}',  [AdminUserPostsController::class, "commentPostUpdate"])->name('admin_user.post.commentUpdate');  // comment update page
                Route::get('/{id}/delete/{comment_id}',  [AdminUserPostsController::class, "commentPostDelete"])->name('admin_user.post.commentDelete');  // comment delete page
                Route::get('/{id}/like/{comment_id}',  [AdminUserPostsController::class, "commentPostLike"])->name('admin_user.post.commentLike');  // comment like page
                Route::get('/{id}/unlike/{comment_id}',  [AdminUserPostsController::class, "commentPostUnlike"])->name('admin_user.post.commentUnlike');  // comment unlike page
            });
        });
    });
});

Route::get('/test', [TestController::class, "test"])->name('test');
Route::post('/testing',  [TestController::class, "testing"])->name('testing');
