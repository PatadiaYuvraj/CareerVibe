<?php

namespace App\Services;

use App\Jobs\SendNotificationJob;
use App\Repository\NotifiableRepository;

class NotifiableService implements NotifiableRepository
{
    public function sendNotification(mixed $user, string $msg): void
    {
        SendNotificationJob::dispatch($user, $msg);
    }
}
