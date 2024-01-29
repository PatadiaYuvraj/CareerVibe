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
  // AuthenticableService has the following methods:
  // registerUser(array $details): User
  // loginUser(array $details): bool
  // logoutUser(): void
  // registerCompany(array $details): Company
  // loginCompany(array $details): bool
  // logoutCompany(): void
  // registerAdmin(array $details): Admin
  // loginAdmin(array $details): bool
  // logoutAdmin(): void
  // passwordHash(string $password): string
  // verifyPassword(string $password, string $hashedPassword): bool
  // isUser(): bool
  // isCompany(): bool
  // isAdmin(): bool

  // registerUser() is used to register a new user
  public function registerUser(array $details): User
  {
    $user = User::create([
      'name' => $details['name'],
      'email' => $details['email'],
      'password' => $this->passwordHash($details['password']),
    ]);

    return $user;
  }

  // loginUser() is used to login a user
  public function loginUser(array $details): bool
  {
    $credentials = [
      'email' => $details['email'],
      'password' => $details['password'],
    ];

    return Auth::guard(
      Config::get('constants.USER_GUARD')
    )->attempt($credentials, true);
  }

  // logoutUser() is used to logout a user
  public function logoutUser(): void
  {
    Auth::guard(
      Config::get('constants.USER_GUARD')
    )->logout();
    Session::flush();
    Session::regenerate();
  }

  // registerCompany() is used to register a new company
  public function registerCompany(array $details): Company
  {
    $company = Company::create([
      'name' => $details['name'],
      'email' => $details['email'],
      'password' => $this->passwordHash($details['password']),
    ]);

    return $company;
  }

  // loginCompany() is used to login a company
  public function loginCompany(array $details): bool
  {
    $credentials = [
      'email' => $details['email'],
      'password' => $details['password'],
    ];

    return Auth::guard(
      Config::get('constants.COMPANY_GUARD')
    )->attempt($credentials, true);
  }

  // logoutCompany() is used to logout a company
  public function logoutCompany(): void
  {
    Auth::guard(Config::get('constants.COMPANY_GUARD'))->logout();
    Session::flush();
    Session::regenerate();
  }

  // registerAdmin() is used to register a new admin
  public function registerAdmin(array $details): Admin
  {
    $admin = Admin::create([
      'name' => $details['name'],
      'email' => $details['email'],
      'password' => $this->passwordHash($details['password']),
    ]);

    return $admin;
  }

  // loginAdmin() is used to login an admin
  public function loginAdmin(array $details): bool
  {
    $credentials = [
      'email' => $details['email'],
      'password' => $details['password'],
    ];

    return Auth::guard(Config::get('constants.ADMIN_GUARD'))->attempt($credentials, true);
  }

  // logoutAdmin() is used to logout an admin
  public function logoutAdmin(): void
  {
    Auth::guard(Config::get('constants.ADMIN_GUARD'))->logout();
    Session::flush();
    Session::regenerate();
  }

  // passwordHash() is used to hash a password
  public function passwordHash(string $password): string
  {
    return Hash::make($password);
  }

  // verifyPassword() is used to verify a password
  public function verifyPassword(string $password, string $hashedPassword): bool
  {
    return Hash::check($password, $hashedPassword);
  }

  // isUser() is used to check if a user is logged in
  public function isUser(): bool
  {
    return Auth::guard(
      Config::get('constants.USER_GUARD')
    )->check();
  }

  // isCompany() is used to check if a company is logged in
  public function isCompany(): bool
  {
    return Auth::guard(
      Config::get('constants.COMPANY_GUARD')
    )->check();
  }

  // isAdmin() is used to check if an admin is logged in
  public function isAdmin(): bool
  {
    return Auth::guard(
      Config::get('constants.ADMIN_GUARD')
    )->check();
  }

  // getUser() is used to get the user that is logged in
  public function getUser(): User|null
  {
    return User::find(Auth::guard(
      Config::get('constants.USER_GUARD')
    )->user()->id);
  }

  // getCompany() is used to get the company that is logged in
  public function getCompany(): Company|null
  {
    return Company::find(Auth::guard(
      Config::get('constants.COMPANY_GUARD')
    )->user()->id);
  }

  // getAdmin() is used to get the admin that is logged in
  public function getAdmin(): Admin|null
  {
    return Admin::find(Auth::guard(
      Config::get('constants.ADMIN_GUARD')
    )->user()->id);
  }

  // getUserById() is used to get a user by id
  public function getUserById(int $id): User|null
  {
    return User::find($id);
  }

  // getCompanyById() is used to get a company by id
  public function getCompanyById(int $id): Company|null
  {
    return Company::find($id);
  }

  // getAdminById() is used to get an admin by id
  public function getAdminById(int $id): Admin|null
  {
    return Admin::find($id);
  }

  // getUserByEmail() is used to get a user by email
  public function getUserByEmail(string $email): User|null
  {
    return User::where('email', $email)->first();
  }

  // getCompanyByEmail() is used to get a company by email
  public function getCompanyByEmail(string $email): Company|null
  {
    return Company::where('email', $email)->first();
  }

  // getAdminByEmail() is used to get an admin by email
  public function getAdminByEmail(string $email): Admin|null
  {
    return Admin::where('email', $email)->first();
  }
}
