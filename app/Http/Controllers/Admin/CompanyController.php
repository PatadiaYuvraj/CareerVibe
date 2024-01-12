<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Services\AuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CompanyController extends Controller
{

    private Company $company;

    public function __construct(Company $company)
    {
        $this->company = $company;
    }

    public function create()
    {
        return view('admin.company.create');
    }

    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            "name" => "required|string|max:60",
            "email" => "required|email|unique:companies,email",
            "password" => "required|string|max:100",
            "password_confirmation" => "required|string|max:100|same:password",
            "website" => "required|string|max:100|url|unique:companies,website",
            "address_line_1" => "required|string|max:100",
        ]);
        if ($validate->passes()) {
            $data = [
                "name" => $request->get("name"),
                "email" => $request->get("email"),
                "password" => $request->get("password"),
                "website" => $request->get("website"),
                "address_line_1" => $request->get("address_line_1"),
                "address_line_2" => $request->get("address_line_2") || null,
                "linkedin_profile" => $request->get("linkedin_profile") || null,
                "description" => $request->get("description") || null,
            ];
            $isCreated = $this->company->create($data);
            if ($isCreated) {
                return redirect()->route('admin.company.index')->with('success', 'Company is created');
            }
            return redirect()->back()->with("warning", "Company is not created");
        }
        if ($validate->fails()) {
            return redirect()->back()->withErrors($validate)->withInput();
        }
    }

    public function index()
    {
        $companies = $this->company->all()->toArray();
        return view('admin.company.index', compact('companies'));
    }

    public function show($id)
    {
        $company = $this->company->where('id', $id)->get()->ToArray();
        if (!$company) {
            return redirect()->back()->with("warning", "Company is not found");
        }
        $company = $company[0];
        return view('admin.company.show', compact('company'));
    }

    public function edit($id)
    {
        $company = $this->company->where('id', $id)->get()->ToArray();
        if (!$company) {
            return redirect()->back()->with("warning", "Company is not found");
        }
        $company = $company[0];
        return view('admin.company.edit', compact('company'));
    }

    public function update(Request $request, $id)
    {
        // if value is available in request then do not validate that value 
        $validate = Validator::make($request->all(), [
            "name" => "required|string|max:60",
            "email" => "required",
            // "password" => "string|max:100",
            "website" => "required|string|max:100",
            // "address_line_1" => "required|string|max:100",
        ]);
        if ($validate->passes()) {
            $data = [
                "name" => $request->get("name"),
                "email" => $request->get("email"),
                "password" => $request->get("password"),
                "website" => $request->get("website"),
                "address_line_1" => $request->get("address_line_1"),
                "address_line_2" => $request->get("address_line_2") || null,
                "linkedin_profile" => $request->get("linkedin_profile") || null,
                "description" => $request->get("description") || null,
            ];
            $isUpdated = $this->company->find($id)->update($data);
            if ($isUpdated) {
                return redirect()->route('admin.company.index')->with('success', 'Company is updated');
            }
            return redirect()->back()->with("warning", "Company is not updated");
        }
        if ($validate->fails()) {
            return redirect()->back()
                ->withErrors($validate)
                ->withInput();
        }
    }

    public function delete($id)
    {
        $isDeleted = $this->company->find($id)->delete();
        if ($isDeleted) {
            return redirect()->route('admin.company.index')->with('success', 'Company is deleted');
        }
        return redirect()->back()->with("warning", "Company is not deleted");
    }

    // toggle verified
    public function toggleVerified($id, $is_verified)
    {
        $auth = new AuthService();
        if (!$auth->isAdmin()) {
            return redirect()->back()->with("warning", "You are not authorized");
        }

        $company = $this->company->where('id', $id)->get()->ToArray();
        if (!$company) {
            return redirect()->back()->with("warning", "Company is not found");
        }
        if ($is_verified == 1) {
            $company->is_verified = 0;
            $company->save();
            return redirect()->back()->with('success', 'Company is unverified');
        } else {
            $company->is_verified = 1;
            $company->save();
            return redirect()->back()->with('success', 'Company is verified');
        }
    }
}
