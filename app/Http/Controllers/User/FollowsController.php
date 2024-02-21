<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Follow;
use App\Models\User;
use App\Services\AuthenticableService;
use App\Services\NavigationManagerService;
use App\Services\NotifiableService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

class FollowsController extends Controller
{

    private NavigationManagerService $navigationManagerService;
    private AuthenticableService $authenticableService;
    private NotifiableService $notifiableService;
    private int $paginate;
    private User $user;
    private Company $company;

    public function __construct(
        User $user,
        Company $company,
        NotifiableService $notifiableService,
        NavigationManagerService $navigationManagerService,
        AuthenticableService $authenticableService,
    ) {
        $this->user = $user;
        $this->company = $company;
        $this->notifiableService = $notifiableService;
        $this->navigationManagerService = $navigationManagerService;
        $this->authenticableService = $authenticableService;
        $this->paginate = Config::get('constants.pagination');
    }

    public function allUsers()
    {
        $current_user_id =  $this->authenticableService->getUser()->id;
        $users = $this->user
            ->where('id', '!=', $current_user_id)
            ->with([
                'followers',
                'following',
                'followingCompanies'
            ])
            ->paginate($this->paginate);
        return $this->navigationManagerService->loadView('user.dashboard.all-users', compact('users'));
    }

    public function follow($id)
    {
        $current_user_id =  $this->authenticableService->getUser()->id;
        $user = $this->user->find($id);

        if (!$user || $current_user_id == $id) {
            return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "User is not found"]);
        }

        $isAlreadyFollowed = $user->followers()->where('user_id', $current_user_id)->exists();

        if ($isAlreadyFollowed) {
            return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "User is already followed"]);
        }

        $user->followers()->syncWithoutDetaching($current_user_id);
        $msg = $this->authenticableService->getUser()->name . " is started following you";
        $this->notifiableService->sendNotification($user, $msg);
        return $this->navigationManagerService->redirectBack(302, [], false, ["success" => "User is followed"]);
    }

    public function unfollow($id)
    {
        $current_user_id =  $this->authenticableService->getUser()->id;
        $user = $this->user->find($id);

        if (!$user) {
            return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "User is not found"]);
        }

        $isAlreadyFollowed = $user->followers()->where('user_id', $current_user_id)->exists();

        if (!$isAlreadyFollowed) {
            return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "User is not followed"]);
        }

        $user->followers()->detach($current_user_id);

        return $this->navigationManagerService->redirectBack(302, [], false, ["success" => "User is unfollowed"]);
    }

    public function removeFollower($id)
    {
        $current_user_id =  $this->authenticableService->getUser()->id;
        $current_user = $this->user->find($current_user_id);
        $user = $this->user->find($id);
        if (!$user) {
            return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "User is not found"]);
        }
        $isAlreadyFollowed = $current_user->followers()->where('user_id', $id)->exists();
        if (!$isAlreadyFollowed) {
            return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "User is not followed"]);
        }
        $current_user->followers()->detach($user->id);
        return $this->navigationManagerService->redirectBack(302, [], false, ["success" => "User is unfollowed"]);
    }

    public function following()
    {
        $user_id =  $this->authenticableService->getUser()->id;
        $users = Follow::where('user_id', $user_id)
            ->with('followable')
            ->paginate($this->paginate);
        return $this->navigationManagerService->loadView('user.dashboard.following', compact('users'));
    }

    public function followers()
    {
        $id =  $this->authenticableService->getUser()->id;
        $user = $this->user->find($id);
        if (!$user) {
            return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "User is not found"]);
        }

        $users = $user->followers()->paginate($this->paginate);
        return $this->navigationManagerService->loadView('user.dashboard.followers', compact('users'));
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
