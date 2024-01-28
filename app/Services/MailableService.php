<?php

namespace App\Services;

use App\Jobs\SendMailJob;
use App\Repository\MailableRepository;

class MailableService implements MailableRepository
{
    public function sendMail(string $email, array $details): void
    {
        // Send mail to user
        SendMailJob::dispatch($email, $details);
    }
}
