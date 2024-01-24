<?php

namespace App\Services;

use App\Jobs\SendNotificationJob;
use App\Repository\SendNotificationRepository;
use Illuminate\Database\Eloquent\Model;

class SendNotificationService implements SendNotificationRepository
{
    public function sendNotification(mixed $user, string $msg): void
    {
        SendNotificationJob::dispatch($user, $msg);
    }
}
