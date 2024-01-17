<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Jobs\DeleteFromCloudinary;
use App\Models\Company;
use Cloudinary\Api\Upload\UploadApi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

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

        $request->validate([
            "name" => [
                "required",
                "string",
                "max:60",
                "min:3"
            ],
            "email" => [
                "required",
                "email",
                "max:100",
                "unique:companies",
            ],
            "password" => [
                "required",
                "string",
                "max:100",
                "min:8",

            ],
            "password_confirmation" => [
                "required",
                "string",
                "max:100",
                "min:8",
                "same:password",
            ],
        ]);

        $data = [
            "name" => $request->get("name"),
            "email" => $request->get("email"),
            "password" => Hash::make($request->get("password")),
        ];

        if ($request->hasFile('profile_image_url')) {
            $request->validate([
                "profile_image_url" => ["required", "image", "mimes:jpeg,png,jpg", "max:2048"],
            ]);
            $stored_path = Storage::putFile('temp', $request->file('profile_image_url'));
            $obj = (new UploadApi())->upload(
                $stored_path,
                [
                    'folder' => 'career-vibe/companies/profile_image',
                    'resource_type' => 'image'
                ]
            );
            $data["profile_image_public_id"] = $obj['public_id'];
            $data["profile_image_url"] = $obj['secure_url'];
            unlink($stored_path);
        }

        if ($request->get('website')) {
            $request->validate([
                "website" => [
                    "required",
                    "string",
                    "max:100",
                ],
            ]);
            $data['website'] = $request->get("website");
        }

        if ($request->get('address_line_1')) {
            $request->validate([
                "address_line_1" => [
                    "required",
                    "string",
                    "max:100",
                ],
            ]);
            $data['address_line_1'] = $request->get("address_line_1");
        }

        if ($request->get('address_line_2')) {
            $request->validate([
                "address_line_2" => [
                    "required",
                    "string",
                    "max:100",
                ],
            ]);
            $data['address_line_2'] = $request->get("address_line_2");
        }

        if ($request->get('linkedin_profile')) {
            $request->validate([
                "linkedin_profile" => [
                    "required",
                    "string",
                    "max:100",
                ],
            ]);
            $data['linkedin_profile'] = $request->get("linkedin_profile");
        }

        if ($request->get('description')) {
            $request->validate([
                "description" => [
                    "required",
                    "string",
                    "max:100",
                ],
            ]);
            $data['description'] = $request->get("description");
        }

        $isCreated = $this->company->create($data);

        if ($isCreated) {
            return redirect()->route('admin.company.index')->with('success', 'Company is created');
        }

        return redirect()->back()->with("warning", "Company is not created");
    }

    public function index()
    {
        $companies = $this->company->withCount('jobs')->paginate(5);
        return view('admin.company.index', compact('companies'));
    }

    public function show($id)
    {
        $company = $this->company->where('id', $id)->with('jobs')->get()->ToArray();
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
        $company = $this->company->where('id', $id)->get()->ToArray();
        if (!$company) {
            return redirect()->back()->with("warning", "Company is not found");
        }
        $company = $company[0];
        $request->validate([
            "name" => [
                "required",
                "string",
                "max:60",
                "min:3"
            ],
            "email" => [
                "required",
                "email",
                "max:100",
            ],
        ]);

        $data = [
            "name" => $request->get("name"),
            "email" => $request->get("email"),
        ];

        if ($request->hasFile('profile_image_url')) {
            $request->validate([
                "profile_image_url" => ["required", "image", "mimes:jpeg,png,jpg", "max:2048"],
            ]);
            $stored_path = Storage::putFile('temp', $request->file('profile_image_url'));
            $obj = (new UploadApi())->upload(
                $stored_path,
                [
                    'folder' => 'career-vibe/companies/profile_image',
                    'resource_type' => 'image'
                ]
            );
            $data["profile_image_public_id"] = $obj['public_id'];
            $data["profile_image_url"] = $obj['secure_url'];
            unlink($stored_path);
        }

        if ($request->get('website')) {
            $request->validate([
                "website" => [
                    "required",
                    "string",
                    "max:100",
                ],
            ]);
            $data['website'] = $request->get("website");
        }

        if ($request->get('address_line_1')) {
            $request->validate([
                "address_line_1" => [
                    "required",
                    "string",
                    "max:100",
                ],
            ]);
            $data['address_line_1'] = $request->get("address_line_1");
        }

        if ($request->get('address_line_2')) {
            $request->validate([
                "address_line_2" => [
                    "required",
                    "string",
                    "max:100",
                ],
            ]);
            $data['address_line_2'] = $request->get("address_line_2");
        }

        if ($request->get('linkedin_profile')) {
            $request->validate([
                "linkedin_profile" => [
                    "required",
                    "string",
                    "max:100",
                ],
            ]);
            $data['linkedin_profile'] = $request->get("linkedin_profile");
        }

        if ($request->get('description')) {
            $request->validate([
                "description" => [
                    "required",
                    "string",
                    "max:100",
                ],
            ]);
            $data['description'] = $request->get("description");
        }

        $isUpdated = $this->company->where('id', $id)->update($data);

        if ($isUpdated) {
            return redirect()->route('admin.company.index')->with('success', 'Company is updated');
        }

        return redirect()->back()->with("warning", "Company is not updated");
    }

    public function delete($id)
    {
        $company = $this->company->where('id', $id)->withCount('jobs')->get()->ToArray();
        if (!$company) {
            return redirect()->back()->with("warning", "Company is not found");
        }
        $company = $company[0];
        if ($company['jobs_count'] > 0) {
            return redirect()->back()->with("warning", "Company has jobs cannot be deleted");
        }
        if ($company['profile_image_url']) {
            $public_ids = $company['profile_image_public_id'];
            DeleteFromCloudinary::dispatch($public_ids);
        }

        $isDeleted = $this->company->where('id', $id)->delete();
        if ($isDeleted) {
            return redirect()->route('admin.company.index')->with('success', 'Company is deleted');
        }
        return redirect()->back()->with("warning", "Company is not deleted");
    }

    public function toggleVerified($id, $is_verified)
    {
        // $auth = new AuthService();
        // if (!$auth->isAdmin()) {
        //     return redirect()->back()->with("warning", "You are not authorized");
        // }
        $company = $this->company->find($id);
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

    public function updateCompanyProfileImage(Request $request, $id)
    {
        $request->validate([
            "profile_image_url" => [
                "required",
                "image",
                "mimes:jpeg,png,jpg",
                "max:2048",
            ],
        ]);

        $company = $this->company->find($id);
        if (!$company) {
            return redirect()->back()->with("warning", "Company is not found");
        }

        if ($company->profile_image_url) {
            $public_ids = $company->profile_image_public_id;
            DeleteFromCloudinary::dispatch($public_ids);
        }

        $stored_path = Storage::putFile('temp', $request->file('profile_image_url'));

        $obj = (new UploadApi())->upload(
            $stored_path,
            [
                'folder' => 'career-vibe/companies/profile_image',
                'resource_type' => 'image'
            ]
        );

        $data = [
            "profile_image_public_id" => $obj['public_id'],
            "profile_image_url" => $obj['secure_url'],
        ];

        $isUpdated = $company->update($data);

        if ($isUpdated) {
            unlink($stored_path);
            return redirect()->back()->with('success', 'Company profile image is updated');
        }

        return redirect()->back()->with("warning", "Company profile image is not updated");
    }

    public function deleteProfileImage($id)
    {
        $company = $this->company->find($id);
        if (!$company) {
            return redirect()->back()->with("warning", "Company is not found");
        }
        if ($company->profile_image_url) {
            $public_ids = $company->profile_image_public_id;
            DeleteFromCloudinary::dispatch($public_ids);

            $data = [
                "profile_image_public_id" => null,
                "profile_image_url" => null,
            ];
        }

        $data = [
            "profile_image_public_id" => null,
            "profile_image_url" => null,
        ];

        $isUpdated = $company->update($data);

        if ($isUpdated) {
            return redirect()->back()->with('success', 'Company profile image is deleted');
        }

        return redirect()->back()->with("warning", "Company profile image is not deleted");
    }
}
