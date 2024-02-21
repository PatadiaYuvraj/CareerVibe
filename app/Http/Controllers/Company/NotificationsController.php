<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Services\AuthenticableService;
use App\Services\NavigationManagerService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

class NotificationsController extends Controller
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

    public function notifications()
    {
        $company = $this->authenticableService->getCompany();
        if (!$company) {
            return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "Company is not found"]);
        }
        $notifications = $company->notifications()->paginate($this->paginate);

        $notifications = $notifications->unique('data');
        return $this->navigationManagerService->loadView('admin_company.dashboard.notifications', compact('notifications'));
    }

    public function markAsRead($id)
    {
        $company = $this->authenticableService->getCompany();
        if (!$company) {
            return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "Company is not found"]);
        }
        $company->notifications()->where('id', $id)->update(['read_at' => now()]);
        return $this->navigationManagerService->redirectBack(302, [], false, ["success" => "Notification is marked as read"]);
    }

    public function markAllAsRead()
    {
        $company = $this->authenticableService->getCompany();
        if (!$company) {
            return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "Company is not found"]);
        }
        $company->unreadNotifications->markAsRead();
        return $this->navigationManagerService->redirectBack(302, [], false, ["success" => "All notifications are marked as read"]);
    }

    public function markAsUnread($id)
    {
        $company = $this->authenticableService->getCompany();
        if (!$company) {
            return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "Company is not found"]);
        }
        $company->notifications()->where('id', $id)->update(['read_at' => null]);
        return $this->navigationManagerService->redirectBack(302, [], false, ["success" => "Notification is marked as unread"]);
    }

    public function deleteNotification($id)
    {
        $company = $this->authenticableService->getCompany();
        if (!$company) {
            return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "Company is not found"]);
        }
        $company->notifications()->where('id', $id)->delete();
        return $this->navigationManagerService->redirectBack(302, [], false, ["success" => "Notification is deleted"]);
    }

    public function deleteAllNotification()
    {
        $company = $this->authenticableService->getCompany();
        if (!$company) {
            return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "Company is not found"]);
        }
        $company->notifications()->delete();
        return $this->navigationManagerService->redirectBack(302, [], false, ["success" => "All notifications are deleted"]);
    }
}
