<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class JobController extends Controller
{
    /*
    
    Route::group(['middleware' => "isCompany"], function () {
        Route::prefix('/user')->group(function () {
            Route::prefix('job')->group(function () {
                Route::get('/',  [UserJobController::class, "index"])->name('user.job.index');
                // Route::get('/search',  [UserJobController::class, "search"])->name('user.job.search');
                // Route::post('/search',  [UserJobController::class, "doSearch"])->name('user.job.doSearch'); 
                Route::get('/{id}',  [UserJobController::class, "show"])->name('user.job.show');
                Route::post('/apply/{id}',  [UserJobController::class, "apply"])->name('user.job.apply');
                Route::get('/applied-jobs',  [UserJobController::class, "appliedJobs"])->name('user.job.appliedJobs');
                Route::get('/cancel-applied-job/{id}',  [UserJobController::class, "cancelAppliedJob"])->name('user.job.cancelAppliedJob');
                Route::get('/save-job/{id}',  [UserJobController::class, "saveJob"])->name('user.job.saveJob');
                Route::get('/unsave-job/{id}',  [UserJobController::class, "unsaveJob"])->name('user.job.unsaveJob');
                Route::get('/saved-jobs',  [UserJobController::class, "savedJobs"])->name('user.job.savedJobs');
                Route::get('/company/{id}',  [UserJobController::class, "jobByCompany"])->name('user.job.jobByCompany');
                Route::get('/location/{id}',  [UserJobController::class, "jobByLocation"])->name('user.job.jobByLocation');
                Route::get('/qualification/{id}',  [UserJobController::class, "jobByQualification"])->name('user.job.jobByQualification');
                Route::get('/profile-category/{id}',  [UserJobController::class, "jobByProfileCategory"])->name('user.job.jobByProfileCategory');
                Route::get('/sub-profile/{id}',  [UserJobController::class, "jobBySubProfile"])->name('user.job.jobBySubProfile');
            });
        });
    });

    */
}
