<?php

namespace App\Repository;

use Illuminate\Http\Request;
use Illuminate\Validation\Validator as ValidationValidator;


interface AdminRepo
{
    public function authorised(array $data): array;
    public function authenticate(array $data): array;
    public function validateAdmin(Request $request, bool $requestfor): ValidationValidator;
    // public function createAdmin(array $data): array;
    public function getAdmins(): array;
    public function getAdminByIdWithoutPassword(int $id): array;
    public function getAdminById(int $id);
    // public function updateAdmin(int $id, array $data): array;
    // public function replaceAdmin(int $id, array $data): array;
    public function deleteAdmin(int $id): array;
}
