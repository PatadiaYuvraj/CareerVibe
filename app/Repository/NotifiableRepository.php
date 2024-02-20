<?php

namespace App\Repository;

use Illuminate\Database\Eloquent\Model;

interface NotifiableRepository
{
    // sendNotification() is used to send notification to user
    public function sendNotification(Model $user, string $msg): void;
}
