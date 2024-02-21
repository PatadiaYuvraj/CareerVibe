<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\User;
use App\Services\AuthenticableService;
use App\Services\MailableService;
use App\Services\NavigationManagerService;
use App\Services\NotifiableService;
use App\Services\StorageManagerService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

class FollowsController extends Controller
{

    private NavigationManagerService $navigationManagerService;
    private AuthenticableService $authenticableService;
    private int $paginate;

    public function __construct(
        NavigationManagerService $navigationManagerService,
        AuthenticableService $authenticableService,
    ) {
        $this->paginate = Config::get('constants.pagination');
        $this->navigationManagerService = $navigationManagerService;
        $this->authenticableService = $authenticableService;
    }

    public function allUsers()
    {
        $company = $this->authenticableService->getCompany();
        if (!$company) {
            return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "Company is not found"]);
        }
        $users = User::with([
            'followers',
            'following',
            'followingCompanies'
        ])->paginate($this->paginate);
        return $this->navigationManagerService->loadView('admin_company.dashboard.all-users', compact('users'));
    }

    public function followers()
    {
        $company = $this->authenticableService->getCompany();
        if (!$company) {
            return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "Company is not found"]);
        }
        $followers = $company->followers()->paginate($this->paginate);
        return $this->navigationManagerService->loadView('admin_company.dashboard.followers', compact('followers'));
    }

    public function removeFollower($id)
    {
        $company = $this->authenticableService->getCompany();
        if (!$company) {
            return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "Company is not found"]);
        }
        $isAlreadyFollowed = $company->followers()->where('user_id', $id)->exists();
        if (!$isAlreadyFollowed) {
            return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "User is not followed"]);
        }
        $company->followers()->detach($id);
        return $this->navigationManagerService->redirectBack(302, [], false, ["success" => "User is unfollowed"]);
    }
}
