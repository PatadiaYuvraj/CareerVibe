<?php

namespace App\Repository;

use Illuminate\Http\Request;
use Illuminate\Validation\Validator as ValidationValidator;


interface CompanyRepo
{
    public function authorised(array $data): array;
    public function authenticate(array $data): array;
    public function validateCompany(Request $request, bool $requestfor): ValidationValidator;
    public function createCompany(array $data): array;
    public function getCompanies(): array;
    public function getCompanyByIdWithoutPassword(int $id): array;
    public function getCompanyById(int $id);
    // public function updateCompany(int $id, array $data): array;
    // public function replaceCompany(int $id, array $data): array;
    public function deleteCompany(int $id): array;
}
