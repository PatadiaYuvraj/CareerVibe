<?php

namespace App\Services;

use App\Jobs\SendMailJob;
use App\Repository\MailableRepository;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;

class MailableService implements MailableRepository
{
    public function sendMail(string $email, array $details): void
    {
        Config::get('constants.IS_MAIL_SERVICE_ENABLED')
            ? SendMailJob::dispatch($email, $details)
            : Log::info('Mail service is disabled');
    }
}
