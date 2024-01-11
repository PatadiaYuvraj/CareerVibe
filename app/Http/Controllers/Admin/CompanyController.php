<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CompanyController extends Controller
{
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
            "website" => "required|string|max:100",
            "address_line_1" => "required|string|max:100",
            "address_line_2" => "string|max:100",
            "linkedin_profile" => "string|max:100",
            "description" => "string|max:100",
        ]);
        if ($validate->passes()) {
            $data = [
                "name" => $request->get("name"),
                "email" => $request->get("email"),
                "password" => $request->get("password"),
                "website" => $request->get("website"),
                "address_line_1" => $request->get("address_line_1"),
                "address_line_2" => $request->get("address_line_2"),
                "linkedin_profile" => $request->get("linkedin_profile"),
                "description" => $request->get("description"),
            ];
            $isCreated = Company::create($data);
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
        $companies = Company::all();
        return view('admin.company.index', compact('companies'));
    }

    // public function show($id)
    // {
    //     // $Company = $this->QetCompanyById($id);
    //     $Company = Company::find($id);
    //     return view('admin.Company.show', compact('Company'));
    // }

    public function edit($id)
    {
        $company = Company::find($id);
        return view('admin.company.edit', compact('company'));
    }

    public function update(Request $request, $id)
    {
        // if value is available in request then do not validate that value 
        $validate = Validator::make($request->all(), [
            "name" => "required|string|max:60",
            "email" => "required",
            "password" => "string|max:100",
            "website" => "required|string|max:100",
            "address_line_1" => "required|string|max:100",
            "address_line_2" => "string|max:100",
            "linkedin_profile" => "string|max:100",
            "description" => "string|max:100",
        ]);
        if ($validate->passes()) {
            $data = [
                "name" => $request->get("name"),
                "email" => $request->get("email"),
                "password" => $request->get("password"),
                "website" => $request->get("website"),
                "address_line_1" => $request->get("address_line_1"),
                "address_line_2" => $request->get("address_line_2"),
                "linkedin_profile" => $request->get("linkedin_profile"),
                "description" => $request->get("description"),
            ];
            $isUpdated = Company::find($id)->update($data);
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
        $isDeleted = Company::find($id)->delete();
        if ($isDeleted) {
            return redirect()->route('admin.company.index')->with('success', 'Company is deleted');
        }
        return redirect()->back()->with("warning", "Company is not deleted");
    }

    // toggle verified
    public function toggleVerified($id)
    {
        $company = Company::find($id);
        if ($company->is_verified == 1) {
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
