<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Services\NavigationManagerService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

class CompanyController extends Controller
{
    private NavigationManagerService $navigationManagerService;
    private int $paginate;
    private Company $company;

    public function __construct(
        Company $company,
        NavigationManagerService $navigationManagerService,
    ) {
        $this->company = $company;
        $this->navigationManagerService = $navigationManagerService;
        $this->paginate = Config::get('constants.pagination');
    }

    public function index()
    {
        $companies = $this->company->with('followers')->paginate($this->paginate);
        dd(collect($companies)->toArray());
        return $this->navigationManagerService->loadView('user.company.index', compact('companies'));
    }

    public function show($id)
    {
        $company = $this->company->with('followers')->find($id);
        if (!$company) {
            return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "Company is not found"]);
        }
        dd($company->toArray());
        return $this->navigationManagerService->loadView('user.company.show', compact('company'));
    }
}
