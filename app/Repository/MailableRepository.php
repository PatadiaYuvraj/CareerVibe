<?php

namespace App\Repository;

interface MailableRepository
{
    // sendMail() is used to send mail
    public function sendMail(string $email, array $details): void;
}
