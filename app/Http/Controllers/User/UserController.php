<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /*
    
    Route::group(['middleware' => "isCompany"], function () {
        Route::prefix('/user')->group(function () {
            Route::get('/edit-profile',  [UserCompanyController::class, "editProfile"])->name('user.editProfile');
            Route::post('/update-profile',  [UserCompanyController::class, "updateProfile"])->name('user.updateProfile');
            Route::get('/change-password',  [UserCompanyController::class, "changePassword"])->name('user.changePassword');
            Route::post('/change-password',  [UserCompanyController::class, "doChangePassword"])->name('user.doChangePassword');
            Route::get('/edit-profile-image',  [UserCompanyController::class, "editProfileImage"])->name('user.editProfileImage');
            Route::post('/update-profile-image',  [UserCompanyController::class, "updateProfileImage"])->name('user.updateProfileImage');
            Route::post('/delete-profile-image',  [UserCompanyController::class, "deleteProfileImage"])->name('user.deleteProfileImage');
            Route::get('/dashboard',  [UserCompanyController::class, "dashboard"])->name('user.dashboard');
            Route::get('/logout',  [UserCompanyController::class, "logout"])->name('user.logout');
        });
    });
    */
}
