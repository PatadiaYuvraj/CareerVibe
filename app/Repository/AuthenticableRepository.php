<?php

namespace App\Repository;

use App\Models\User;
use App\Models\Company;
use App\Models\Admin;

interface AuthenticableRepository
{
  // AuthenticableService has the following methods:
  // registerUser(array $details): User -> register a new user
  // loginUser(array $details): bool -> login a user
  // logoutUser(): void -> logout a user
  // registerCompany(array $details): Company -> register a new company
  // loginCompany(array $details): bool -> login a company
  // logoutCompany(): void  -> logout a company
  // registerAdmin(array $details): Admin -> register a new admin
  // loginAdmin(array $details): bool -> login an admin
  // logoutAdmin(): void  -> logout an admin
  // passwordHash(string $password): string -> hash a password
  // verifyPassword(string $password, string $hashedPassword): bool -> verify a password
  // isUser(): bool -> check if a user is logged in
  // isCompany(): bool  -> check if a company is logged in
  // isAdmin(): bool  -> check if an admin is logged in
  // getUser(): User  -> get the logged in user
  // getCompany(): Company  -> get the logged in company
  // getAdmin(): Admin  -> get the logged in admin
  // getUserById(int $id): User  -> get a user by id
  // getCompanyById(int $id): Company  -> get a company by id
  // getAdminById(int $id): Admin  -> get an admin by id
  // getUserByEmail(string $email): User  -> get a user by email
  // getCompanyByEmail(string $email): Company  -> get a company by email
  // getAdminByEmail(string $email): Admin  -> get an admin by email


  // registerUser() is used to register a new user
  public function registerUser(array $details): User;

  // loginUser() is used to login a user
  public function loginUser(array $details): bool;

  // logoutUser() is used to logout a user
  public function logoutUser(): void;

  // registerCompany() is used to register a new company
  public function registerCompany(array $details): Company;

  // loginCompany() is used to login a company
  public function loginCompany(array $details): bool;

  // logoutCompany() is used to logout a company
  public function logoutCompany(): void;

  // registerAdmin() is used to register a new admin
  public function registerAdmin(array $details): Admin;

  // loginAdmin() is used to login an admin
  public function loginAdmin(array $details): bool;

  // logoutAdmin() is used to logout an admin
  public function logoutAdmin(): void;

  // passwordHash() is used to hash a password
  public function passwordHash(string $password): string;

  // verifyPassword() is used to verify a password
  public function verifyPassword(string $password, string $hashedPassword): bool;

  // isUser() is used to check if a user is logged in
  public function isUser(): bool;

  // isCompany() is used to check if a company is logged in
  public function isCompany(): bool;

  // isAdmin() is used to check if an admin is logged in
  public function isAdmin(): bool;

  // getUser() is used to get the logged in user
  public function getUser(): User;

  // getCompany() is used to get the logged in company
  public function getCompany(): Company;

  // getAdmin() is used to get the logged in admin
  public function getAdmin(): Admin;

  // getUserById() is used to get a user by id
  public function getUserById(int $id): User;

  // getCompanyById() is used to get a company by id
  public function getCompanyById(int $id): Company;

  // getAdminById() is used to get an admin by id
  public function getAdminById(int $id): Admin;

  // getUserByEmail() is used to get a user by email
  public function getUserByEmail(string $email): User;

  // getCompanyByEmail() is used to get a company by email
  public function getCompanyByEmail(string $email): Company;

  // getAdminByEmail() is used to get an admin by email
  public function getAdminByEmail(string $email): Admin;
}
