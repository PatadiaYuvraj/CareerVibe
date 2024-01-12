<?php

namespace App\Repository;

interface AuthRepo
{
    public function isUser(): bool;
    public function isAdmin(): bool;
    public function isCompany(): bool;
}
