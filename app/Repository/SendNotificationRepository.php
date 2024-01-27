<?php

namespace App\Repository;

use Illuminate\Database\Eloquent\Model;

interface SendNotificationRepository
{
    // sendNotification() is used to send notification to user
    public function sendNotification(mixed $user, string $msg): void;
}
