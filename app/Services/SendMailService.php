<?php

namespace App\Services;

use App\Jobs\SendMailJob;
use App\Repository\SendMailRepository;

class SendMailService implements SendMailRepository
{
    public function sendMail(string $email, array $details): void
    {
        // Send mail to user
        SendMailJob::dispatch($email, $details);
    }
}
