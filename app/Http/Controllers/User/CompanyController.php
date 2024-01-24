<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Job;
use App\Models\User;
use App\Services\SendMailService;
use App\Services\SendNotificationService;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    private Company $company;
    private Job $job;
    private User $user;
    private SendMailService $sendMailService;
    private SendNotificationService $sendNotificationService;

    public function __construct(Company $company, Job $job, User $user, SendMailService $sendMailService, SendNotificationService $sendNotificationService)
    {
        $this->company = $company;
        $this->job = $job;
        $this->user = $user;
        $this->sendMailService = $sendMailService;
        $this->sendNotificationService = $sendNotificationService;
    }



    public function allCompany()
    {
        $companies = $this->company->with('followers')
            // ->get()->toArray();
            ->paginate(10);
        return view('user.company.index', compact('companies'));
    }

    public function followCompany($company_id)
    {
        $current_user_id = auth()->guard('user')->user()->id;
        $company = $this->company->find($company_id);

        if (!$company) {
            return redirect()->back()->with("warning", "Company not found");
        }

        $isAlreadyFollowed = $company->followers()->where('user_id', $current_user_id)->exists();

        if ($isAlreadyFollowed) {
            return redirect()->back()->with("warning", "User is already followed");
        }

        $company->followers()->syncWithoutDetaching($current_user_id);

        $msg = auth()->guard('user')->user()->name . " is started following you";

        // UNCOMMENT: To send notification
        $this->sendNotificationService->sendNotification($company, $msg);


        return redirect()->back()->with("success", "User is followed");
    }


    public function unfollowCompany($id)
    {
        $current_user_id = auth()->guard('user')->user()->id;
        $company = $this->company->find($id);

        if (!$company) {
            return redirect()->back()->with("warning", "Company not found");
        }
        $isAlreadyFollowed = $company->followers()->where('user_id', $current_user_id)->exists();

        if (!$isAlreadyFollowed) {
            return redirect()->back()->with("warning", "User is not followed");
        }

        $company->followers()->detach($current_user_id);

        return redirect()->back()->with("success", "User is unfollowed");
    }
}
