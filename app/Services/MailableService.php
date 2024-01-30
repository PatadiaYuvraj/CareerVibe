<?php

namespace App\Services;

use App\Jobs\EmailVerificationJob;
use App\Jobs\SendMailJob;
use App\Repository\MailableRepository;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;

class MailableService implements MailableRepository
{
    public function sendMail(string $email, array $details): void
    {
        if (Config::get('constants.IS_MAIL_SERVICE_ENABLED')) {
            // SendMailJob::dispatch($email, $details);
            Log::info("MailableService : " . json_encode($details));
        } else {
            Log::info("Mail service is disabled");
        }
    }

    public function emailVerificationMail(string $email, array $details): void
    {
        if (Config::get('constants.IS_MAIL_SERVICE_ENABLED')) {
            EmailVerificationJob::dispatch($email, $details);
            Log::info("MailableService : " . json_encode($details));
        } else {
            Log::info("Mail service is disabled");
        }
    }
}
