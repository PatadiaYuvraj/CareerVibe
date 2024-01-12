<?php

namespace App\Services;

use App\Repository\AuthRepo;
use Illuminate\Support\Facades\Auth;

class AuthService implements AuthRepo
{
    public function isUser(): bool
    {
        return Auth::guard('user')->check();
    }

    public function isAdmin(): bool
    {
        return Auth::guard('admin')->check();
    }

    public function isCompany(): bool
    {
        return Auth::guard('company')->check();
    }
}
