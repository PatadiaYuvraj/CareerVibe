<?php

namespace App\Services;

use App\Jobs\SendNotificationJob;
use App\Repository\NotifiableRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;

class NotifiableService implements NotifiableRepository
{
    public function sendNotification(Model $user, string $msg): void
    {
        if (!Config::get('constants.IS_NOTIFICATION_SERVICE_ENABLED')) {
            Log::info('Notification service is disabled');
            return;
        }
        SendNotificationJob::dispatch($user, $msg);
    }
}
