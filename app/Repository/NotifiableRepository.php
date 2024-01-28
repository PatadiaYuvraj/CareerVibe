<?php

namespace App\Repository;

interface NotifiableRepository
{
    // sendNotification() is used to send notification to user
    public function sendNotification(mixed $user, string $msg): void;
}
