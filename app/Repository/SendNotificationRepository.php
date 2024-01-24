<?php

namespace App\Repository;

use Illuminate\Database\Eloquent\Model;

interface SendNotificationRepository
{
    public function sendNotification(mixed $user, string $msg): void;
}
