<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\AuthenticableService;
use App\Services\NavigationManagerService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

class NotificationsController extends Controller
{

    private User $user;
    private int $paginate;
    private NavigationManagerService $navigationManagerService;
    private AuthenticableService $authenticableService;

    public function __construct(
        User $user,
        NavigationManagerService $navigationManagerService,
        AuthenticableService $authenticableService,
    ) {
        $this->user = $user;
        $this->navigationManagerService = $navigationManagerService;
        $this->authenticableService = $authenticableService;
        $this->paginate = Config::get('constants.pagination');
    }

    public function notifications()
    {
        $user_id =  $this->authenticableService->getUser()->id;
        $user = $this->user->find($user_id);
        if (!$user) {
            return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "User is not found"]);
        }
        $notifications = $user->notifications()->paginate($this->paginate);

        $notifications = $notifications->unique('data');
        return $this->navigationManagerService->loadView('user.dashboard.notifications', compact('notifications'));
    }

    public function markAsRead($id)
    {
        $user_id =  $this->authenticableService->getUser()->id;
        $user = $this->user->find($user_id);
        if (!$user) {
            return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "User is not found"]);
        }
        $user->notifications()->where('id', $id)->update(['read_at' => now()]);
        return $this->navigationManagerService->redirectBack(302, [], false, ["success" => "Notification is marked as read"]);
    }

    public function markAllAsRead()
    {
        $user_id =  $this->authenticableService->getUser()->id;
        $user = $this->user->find($user_id);
        if (!$user) {
            return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "User is not found"]);
        }
        $user->unreadNotifications->markAsRead();
        return $this->navigationManagerService->redirectBack(302, [], false, ["success" => "All notifications are marked as read"]);
    }

    public function markAsUnread($id)
    {
        $user_id =  $this->authenticableService->getUser()->id;
        $user = $this->user->find($user_id);
        if (!$user) {
            return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "User is not found"]);
        }
        $user->notifications()->where('id', $id)->update(['read_at' => null]);
        return $this->navigationManagerService->redirectBack(302, [], false, ["success" => "Notification is marked as unread"]);
    }

    public function deleteNotification($id)
    {
        $user_id =  $this->authenticableService->getUser()->id;
        $user = $this->user->find($user_id);
        if (!$user) {
            return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "User is not found"]);
        }
        $user->notifications()->where('id', $id)->delete();
        return $this->navigationManagerService->redirectBack(302, [], false, ["success" => "Notification is deleted"]);
    }

    public function deleteAllNotification()
    {
        $user_id =  $this->authenticableService->getUser()->id;
        $user = $this->user->find($user_id);
        if (!$user) {
            return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "User is not found"]);
        }
        $user->notifications()->delete();
        return $this->navigationManagerService->redirectBack(302, [], false, ["success" => "All notifications are deleted"]);
    }
}
