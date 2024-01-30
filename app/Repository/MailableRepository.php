<?php

namespace App\Repository;

interface MailableRepository
{
    // sendMail() is used to send mail
    public function sendMail(string $email, array $details): void;

    // emailVerificationMail() is used to send email verification mail
    public function emailVerificationMail(string $email, array $details): void;
}
