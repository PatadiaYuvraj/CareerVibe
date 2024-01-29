<?php

namespace App\Services;

use App\Jobs\SendNotificationJob;
use App\Repository\NotifiableRepository;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;

class NotifiableService implements NotifiableRepository
{
    public function sendNotification(mixed $user, string $msg): void
    {
        // SendNotificationJob::dispatch($user, $msg);
        Config::get('constants.IS_NOTIFICATION_SERVICE_ENABLED')
            ? SendNotificationJob::dispatch($user, $msg)
            : Log::info('Notification service is disabled');
    }
}
