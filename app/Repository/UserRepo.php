<?php

namespace App\Repository;

use Illuminate\Http\Request;
use Illuminate\Validation\Validator as ValidationValidator;


interface UserRepo
{
    public function authenticate(array $data): array;
    public function validateUser(Request $request, bool $requestfor): ValidationValidator;
    public function createUser(array $data): array;
    public function getUsers(): array;
    // public function getUserByIdWithoutPassword(int $id): array;
    public function getUserById(int $id);
    public function updateUser(int $id, array $data): array;
    public function replaceUser(int $id, array $data): array;
    public function deleteUser(int $id): bool;
}
