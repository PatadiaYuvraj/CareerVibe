<?php

namespace App\Services;

use App\Models\User;
use App\Models\Company;
use App\Models\Admin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;

use App\Repository\AuthenticableRepository;
use Illuminate\Support\Facades\Config;

class AuthenticableService implements AuthenticableRepository
{

    // User related methods

    public function registerUser(array $details): User
    {
        $user = new User();
        $user->name = $details['name'];
        $user->email = $details['email'];
        $user->password = $this->passwordHash($details['password']);
        $user->email_verification_token = $details['email_verification_token'];
        $user->is_email_verified = false;
        $user->email_verified_at = null;
        $user->save();

        return $user;
    }

    public function loginUser(array $details): bool
    {
        $credentials = [
            'email' => $details['email'],
            'password' => $details['password'],
        ];

        return Auth::guard(
            Config::get('constants.USER_GUARD')
        )->attempt($credentials);
    }

    public function logoutUser(): void
    {
        Auth::guard(
            Config::get('constants.USER_GUARD')
        )->logout();
        Session::flush();
        Session::regenerate();
    }

    public function isUser(): bool
    {
        return Auth::guard(
            Config::get('constants.USER_GUARD')
        )->check();
    }

    public function getUser(): User|null
    {
        return Auth::guard(
            Config::get('constants.USER_GUARD')
        )->user();
    }

    public function getUserById(int $id): User|null
    {
        return User::find($id);
    }

    public function getUserByEmail(string $email): User|null
    {
        return User::where('email', $email)->first();
    }

    public function generateUserEmailVerificationLink(string $routeName, string $token): string
    {
        return $this->generateLink(
            $routeName,
            $token
        );
    }

    public function generateUserPasswordResetLink(string $routeName, string $token): string
    {
        return $this->generateLink(
            $routeName,
            $token
        );
    }

    // Company related methods

    public function registerCompany(array $details): Company
    {
        $company = new Company();
        $company->name = $details['name'];
        $company->email = $details['email'];
        $company->password = $this->passwordHash($details['password']);
        $company->email_verification_token = $details['email_verification_token'];
        $company->is_email_verified = false;
        $company->email_verified_at = null;
        $company->save();

        return $company;
    }

    public function loginCompany(array $details): bool
    {
        $credentials = [
            'email' => $details['email'],
            'password' => $details['password'],
        ];

        return Auth::guard(
            Config::get('constants.COMPANY_GUARD')
        )->attempt($credentials);
    }

    public function logoutCompany(): void
    {
        Auth::guard(Config::get('constants.COMPANY_GUARD'))->logout();
        Session::flush();
        Session::regenerate();
    }

    public function isCompany(): bool
    {
        return Auth::guard(
            Config::get('constants.COMPANY_GUARD')
        )->check();
    }

    public function getCompany(): Company|null
    {
        return auth()->guard(
            Config::get('constants.COMPANY_GUARD')
        )->user();
    }

    public function getCompanyById(int $id): Company|null
    {
        return Company::find($id);
    }

    public function getCompanyByEmail(string $email): Company|null
    {
        return Company::where('email', $email)->first();
    }

    public function generateCompanyEmailVerificationLink(string $routeName, string $token): string
    {
        return $this->generateLink(
            $routeName,
            $token
        );
    }

    public function generateCompanyPasswordResetLink(string $routeName, string $token): string
    {
        return $this->generateLink(
            $routeName,
            $token
        );
    }

    // Admin related methods

    public function registerAdmin(array $details): Admin
    {
        $admin = new Admin();
        $admin->name = $details['name'];
        $admin->email = $details['email'];
        $admin->password = $this->passwordHash($details['password']);
        $admin->email_verification_token = $details['email_verification_token'];
        $admin->is_email_verified = false;
        $admin->email_verified_at = null;
        $admin->save();

        return $admin;
    }

    public function loginAdmin(array $details): bool
    {
        $credentials = [
            'email' => $details['email'],
            'password' => $details['password'],
        ];

        return Auth::guard(Config::get('constants.ADMIN_GUARD'))->attempt($credentials);
    }

    public function logoutAdmin(): void
    {
        Auth::guard(Config::get('constants.ADMIN_GUARD'))->logout();
        Session::flush();
        Session::regenerate();
    }

    public function isAdmin(): bool
    {
        return Auth::guard(
            Config::get('constants.ADMIN_GUARD')
        )->check();
    }

    public function getAdmin(): Admin|null
    {
        return Admin::find(Auth::guard(
            Config::get('constants.ADMIN_GUARD')
        )->user()->id);
    }

    public function getAdminById(int $id): Admin|null
    {
        return Admin::find($id);
    }

    public function getAdminByEmail(string $email): Admin|null
    {
        return Admin::where('email', $email)->first();
    }

    public function generateAdminEmailVerificationLink(string $routeName, string $token): string
    {
        return $this->generateLink(
            $routeName,
            $token
        );
    }

    public function generateAdminPasswordResetLink(string $routeName, string $token): string
    {
        return $this->generateLink(
            $routeName,
            $token
        );
    }

    // Common methods

    public function passwordHash(string $password): string
    {
        return Hash::make($password);
    }

    public function verifyPassword(string $password, string $hashedPassword): bool
    {
        return Hash::check($password, $hashedPassword);
    }

    public function generateToken(): string
    {
        return bin2hex(random_bytes(50));
    }

    public function generateEmailVerificationToken(): string
    {
        return $this->generateToken();
    }

    public function generatePasswordResetToken(): string
    {
        return $this->generateToken();
    }

    public function generateLink(string $routeName, string $token): string
    {
        return route(
            $routeName,
            $token
        );
    }
}
