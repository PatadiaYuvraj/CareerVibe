<?php

namespace App\Repository;

use App\Models\User;
use App\Models\Company;
use App\Models\Admin;

interface AuthenticableRepository
{
  // User related methods
  public function registerUser(array $details): User;
  public function loginUser(array $details): bool;
  public function logoutUser(): void;
  public function isUser(): bool;
  public function getUser(): User|null;
  public function getUserById(int $id): User|null;
  public function getUserByEmail(string $email): User|null;
  public function generateUserEmailVerificationLink(string $routeName, string $token): string;
  public function generateUserPasswordResetLink(string $routeName, string $token): string;

  // Company related methods
  public function registerCompany(array $details): Company;
  public function loginCompany(array $details): bool;
  public function logoutCompany(): void;
  public function isCompany(): bool;
  public function getCompany(): Company|null;
  public function getCompanyById(int $id): Company|null;
  public function getCompanyByEmail(string $email): Company|null;
  public function generateCompanyEmailVerificationLink(string $routeName, string $token): string;
  public function generateCompanyPasswordResetLink(string $routeName, string $token): string;

  // Admin related methods
  public function registerAdmin(array $details): Admin;
  public function loginAdmin(array $details): bool;
  public function logoutAdmin(): void;
  public function isAdmin(): bool;
  public function getAdmin(): Admin|null;
  public function getAdminById(int $id): Admin|null;
  public function getAdminByEmail(string $email): Admin|null;
  public function generateAdminEmailVerificationLink(string $routeName, string $token): string;
  public function generateAdminPasswordResetLink(string $routeName, string $token): string;

  // Common methods
  public function passwordHash(string $password): string;
  public function verifyPassword(string $password, string $hashedPassword): bool;
  public function generateToken(): string;
  public function generateEmailVerificationToken(): string;
  public function generatePasswordResetToken(): string;
  public function generateLink(string $routeName, string $token): string;
}
