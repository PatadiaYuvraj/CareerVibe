<?php

namespace App\Services;

use App\Repository\AuthRepo;

class AuthService implements AuthRepo
{
    public function isUser(): bool
    {
        return auth()->guard('user')->check();
    }

    public function isAdmin(): bool
    {
        return auth()->guard('admin')->check();
    }

    public function isCompany(): bool
    {
        return auth()->guard('company')->check();
    }
}
