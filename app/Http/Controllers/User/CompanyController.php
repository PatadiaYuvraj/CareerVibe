<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Services\NavigationManagerService;
use App\Services\SendNotificationService;

class CompanyController extends Controller
{
    private Company $company;
    private SendNotificationService $sendNotificationService;
    private NavigationManagerService $navigationManagerService;

    public function __construct(
        Company $company,
        SendNotificationService $sendNotificationService,
        NavigationManagerService $navigationManagerService
    ) {
        $this->company = $company;
        $this->sendNotificationService = $sendNotificationService;
        $this->navigationManagerService = $navigationManagerService;
    }



    public function allCompany()
    {
        $companies = $this->company->with('followers')->paginate(10);
        $navigation = $this->navigationManagerService->loadView('user.company.index', compact('companies'));
    }

    public function followCompany($company_id)
    {
        $current_user_id = auth()->guard('user')->user()->id;
        $company = $this->company->find($company_id);

        if (!$company) {
            return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "Company not found"]);
        }

        $isAlreadyFollowed = $company->followers()->where('user_id', $current_user_id)->exists();

        if ($isAlreadyFollowed) {
            return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "User is already followed"]);
        }

        $company->followers()->syncWithoutDetaching($current_user_id);

        $msg = auth()->guard('user')->user()->name . " is started following you";
        $this->sendNotificationService->sendNotification($company, $msg);
        return $this->navigationManagerService->redirectBack(302, [], false, ["success" => "User is followed"]);
    }


    public function unfollowCompany($id)
    {
        $current_user_id = auth()->guard('user')->user()->id;
        $company = $this->company->find($id);
        if (!$company) {
            return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "Company not found"]);
        }
        $isAlreadyFollowed = $company->followers()->where('user_id', $current_user_id)->exists();
        if (!$isAlreadyFollowed) {
            return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "User is not followed"]);
        }
        $company->followers()->detach($current_user_id);
        return $this->navigationManagerService->redirectBack(302, [], false, ["success" => "User is unfollowed"]);
    }
}
