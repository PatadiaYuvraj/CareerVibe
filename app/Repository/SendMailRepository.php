<?php

namespace App\Repository;

interface SendMailRepository
{
    public function sendMail(string $email, array $details): void;
}
