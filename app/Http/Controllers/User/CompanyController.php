<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Services\AuthenticableService;
use App\Services\NavigationManagerService;
use App\Services\NotifiableService;
use Illuminate\Support\Facades\Config;

class CompanyController extends Controller
{
    private Company $company;
    private NavigationManagerService $navigationManagerService;
    private NotifiableService $notifiableService;
    private AuthenticableService $authenticableService;
    private int $paginate;

    public function __construct(
        Company $company,
        NavigationManagerService $navigationManagerService,
        NotifiableService $notifiableService,
        AuthenticableService $authenticableService
    ) {
        $this->company = $company;
        $this->navigationManagerService = $navigationManagerService;
        $this->notifiableService = $notifiableService;
        $this->authenticableService = $authenticableService;
        $this->paginate = Config::get('constants.pagination');
    }

    public function allCompany()
    {
        $companies = $this->company->with('followers')->paginate($this->paginate);
        return $this->navigationManagerService->loadView('user.company.index', compact('companies'));
    }

    public function followCompany($company_id)
    {
        $user = $this->authenticableService->getUser();
        $company = $this->company->find($company_id);

        if (!$company) {
            return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "Company not found"]);
        }

        $isAlreadyFollowed = $company->followers()->where(
            'user_id',
            $user->id
        )->exists();

        if ($isAlreadyFollowed) {
            return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "User is already followed"]);
        }

        $company->followers()->syncWithoutDetaching($user->id);

        $msg = $user->name . " is started following you";
        $this->notifiableService->sendNotification($company, $msg);
        return $this->navigationManagerService->redirectBack(302, [], false, ["success" => "User is followed"]);
    }


    public function unfollowCompany($id)
    {
        $current_user_id = $this->authenticableService->getUser()->id;
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
