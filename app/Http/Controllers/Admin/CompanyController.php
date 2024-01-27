<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Services\StorageManagerService;
use App\Services\SendMailService;
use App\Services\SendNotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class CompanyController extends Controller
{
    private SendNotificationService $sendNotificationService;
    private SendMailService $sendMailService;
    private Company $company;
    private int $paginate;
    private StorageManagerService $StorageManagerService;

    public function __construct(
        Company $company,
        SendNotificationService $sendNotificationService,
        SendMailService $sendMailService,
        StorageManagerService $StorageManagerService
    ) {
        $this->paginate = env('PAGINATEVALUE');
        $this->company = $company;
        $this->sendNotificationService = $sendNotificationService;
        $this->sendMailService = $sendMailService;
        $this->StorageManagerService = $StorageManagerService;
    }

    public function create()
    {
        return view('admin.company.create');
    }

    public function store(Request $request)
    {
        $hasFile = false;
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
            $data["profile_image_public_id"] = null;
            $data["profile_image_url"] = null;
            $hasFile = true;
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

        if ($request->get('city')) {
            $request->validate([
                "city" => [
                    "required",
                    "string",
                    "max:100",
                ],
            ]);
            $data['city'] = $request->get("city");
        }

        if ($request->get('address')) {
            $request->validate([
                "address" => [
                    "required",
                    "string",
                    "max:100",
                ],
            ]);
            $data['address'] = $request->get("address");
        }

        if ($request->get('linkedin')) {
            $request->validate([
                "linkedin" => [
                    "required",
                    "string",
                    "max:100",
                ],
            ]);
            $data['linkedin'] = $request->get("linkedin");
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
            $msg = "Company is created";
            if ($hasFile) {
                $this->StorageManagerService->uploadToCloudinary($request, "COMPANY", $isCreated->id);
            }
            // MAIL: when company is created send mail to company and admin
            return redirect()->route('admin.company.index')->with('success', $msg);
        }

        return redirect()->back()->with("warning", "Company is not created");
    }

    public function index()
    {
        $companies = $this->company->withCount('jobs')->paginate($this->paginate);
        return view('admin.company.index', compact('companies'));
    }

    public function show($id)
    {
        $company = $this->company->where('id', $id)->with([
            'jobs' => function ($query) {
                $query->with('subProfile');
            }
        ])->get()->ToArray();
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
            $data["profile_image_public_id"] = null;
            $data["profile_image_url"] = null;
            // ClouadStorageManager : To upload image to cloudinary
            $this->StorageManagerService->uploadToCloudinary($request, "COMPANY", $company['id']);
        }

        $data['website'] = $data['city'] = $data['address'] = $data['linkedin'] = $data['description'] = null;
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

        if ($request->get('city')) {
            $request->validate([
                "city" => [
                    "required",
                    "string",
                    "max:100",
                ],
            ]);
            $data['city'] = $request->get("city");
        }

        if ($request->get('address')) {
            $request->validate([
                "address" => [
                    "required",
                    "string",
                    "max:100",
                ],
            ]);
            $data['address'] = $request->get("address");
        }

        if ($request->get('linkedin')) {
            $request->validate([
                "linkedin" => [
                    "required",
                    "string",
                    "max:100",
                ],
            ]);
            $data['linkedin'] = $request->get("linkedin");
        }

        if ($request->get('description')) {
            $request->validate([
                "description" => [
                    "required",
                    "string",
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
            $this->StorageManagerService->deleteFromCloudinary($public_ids);
        }

        $isDeleted = $this->company->where('id', $id)->delete();
        if ($isDeleted) {
            return redirect()->route('admin.company.index')->with('success', 'Company is deleted');
        }
        return redirect()->back()->with("warning", "Company is not deleted");
    }

    public function toggleVerified($id, $is_verified)
    {
        if (!auth()->guard('admin')->check()) {
            return redirect()->back()->with("warning", "You are not authorized");
        }
        $company = $this->company->find($id);
        if (!$company) {
            return redirect()->back()->with("warning", "Company is not found");
        }
        if ($is_verified == 1) {
            $company->is_verified = 0;
            $company->save();

            $details = [
                'title' => 'Company is unverified',
                'body' => "Your company is unverified by admin, please contact admin"
            ];
            // UNCOMMENT: To send notification
            $this->sendNotificationService->sendNotification($company, $details['body']);
            // UNCOMMENT: To send mail
            $this->sendMailService->sendMail($company->email, $details);
            return redirect()->back()->with('success', 'Company is unverified');
        } else {
            $company->is_verified = 1;
            $company->save();
            $details = [
                'title' => 'Company is verified',
                'body' => "Your company is verified by admin, now you can post jobs"
            ];
            // UNCOMMENT: To send notification
            $this->sendNotificationService->sendNotification($company, $details['body']);
            // UNCOMMENT: To send mail
            $this->sendMailService->sendMail($company->email, $details);
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
            $this->StorageManagerService->deleteFromCloudinary($public_ids);
        }
        // CloudStorageManager : To upload image to cloudinary
        $this->StorageManagerService->uploadToCloudinary($request, "COMPANY", $company->id);

        $data = [
            "profile_image_public_id" => null,
            "profile_image_url" => null,
        ];

        $isUpdated = $company->update($data);

        if ($isUpdated) {
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
            $this->StorageManagerService->deleteFromCloudinary($public_ids);

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
