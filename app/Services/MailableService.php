<?php

namespace App\Services;

use App\Jobs\EmailVerificationJob;
use App\Jobs\PasswordResetJob;
use App\Jobs\SendMailJob;
use App\Repository\MailableRepository;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;

class MailableService implements MailableRepository
{
    public function sendMail(string $email, array $details): void
    {
        if (!Config::get('constants.IS_MAIL_SERVICE_ENABLED')) {
            Log::info("Mail service is disabled");
            return;
        }
        SendMailJob::dispatch($email, $details);
    }

    public function emailVerificationMail(string $email, array $details): void
    {
        if (!Config::get('constants.IS_MAIL_SERVICE_ENABLED')) {
            Log::info("Mail service is disabled");
            return;
        }
        EmailVerificationJob::dispatch($email, $details);
    }

    public function passwordResetMail(string $email, array $details): void
    {
        if (!Config::get('constants.IS_MAIL_SERVICE_ENABLED')) {
            Log::info("Mail service is disabled");
            return;
        }
        PasswordResetJob::dispatch($email, $details);
    }
}
