<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Company;
use App\Models\Like;
use App\Models\Post;
use App\Services\AuthenticableService;
use App\Services\MailableService;
use App\Services\NavigationManagerService;
use App\Services\NotifiableService;
use App\Services\StorageManagerService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

class CompanyController extends Controller
{
    private NotifiableService $notifiableService;
    private MailableService $mailableService;
    private Company $company;
    private int $paginate;
    private StorageManagerService $storageManagerService;
    private NavigationManagerService $navigationManagerService;
    private AuthenticableService $authenticableService;

    public function __construct(
        Company $company,
        NotifiableService $notifiableService,
        MailableService $mailableService,
        StorageManagerService $storageManagerService,
        NavigationManagerService $navigationManagerService,
        AuthenticableService $authenticableService,
    ) {
        $this->paginate = Config::get('constants.pagination');
        $this->company = $company;
        $this->notifiableService = $notifiableService;
        $this->mailableService = $mailableService;
        $this->storageManagerService = $storageManagerService;
        $this->navigationManagerService = $navigationManagerService;
        $this->authenticableService = $authenticableService;
    }

    public function create()
    {
        return $this->navigationManagerService->loadView('admin.company.create');
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
            "password" => $this->authenticableService->passwordHash($request->get("password")),
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
                $this->storageManagerService->uploadToCloudinary($request, "COMPANY", $isCreated->id);
            }
            // MAIL: when company is created send mail to company and admin
            return $this->navigationManagerService->redirectRoute('admin.company.index', [], 302, [], false, ["success" => $msg]);
        }

        return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "Company is not created"]);
    }

    public function index()
    {
        $companies = $this->company->withCount('jobs')->paginate($this->paginate);
        return $this->navigationManagerService->loadView('admin.company.index', compact('companies'));
    }

    public function show($id)
    {
        $company = $this->company->where('id', $id)->with([
            'jobs' => function ($query) {
                $query->with('subProfile');
            }
        ])->get()->ToArray();
        if (!$company) {
            return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "Company is not found"]);
        }
        $company = $company[0];
        return $this->navigationManagerService->loadView('admin.company.show', compact('company'));
    }

    public function edit($id)
    {
        $company = $this->company->where('id', $id)->get()->ToArray();
        if (!$company) {
            return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "Company is not found"]);
        }
        $company = $company[0];
        return $this->navigationManagerService->loadView('admin.company.edit', compact('company'));
    }

    public function update(Request $request, $id)
    {
        $company = $this->company->where('id', $id)->get()->ToArray();
        if (!$company) {
            return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "Company is not found"]);
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
            $this->storageManagerService->uploadToCloudinary($request, "COMPANY", $company['id']);
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
        $isUpdated = $this->company->find($id)->update($data);

        if ($isUpdated) {
            return $this->navigationManagerService->redirectRoute('admin.company.index', [], 302, [], false, ["success" => "Company is updated"]);
        }
        return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "Company is not updated"]);
    }

    public function destroy($id)
    {
        $company = $this->company->where('id', $id)->withCount('jobs')->get()->ToArray();
        if (!$company) {
            return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "Company is not found"]);
        }
        $company = $company[0];
        if ($company['jobs_count'] > 0) {
            return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "Company has jobs cannot be deleted"]);
        }
        if ($company['profile_image_url']) {
            $public_ids = $company['profile_image_public_id'];
            $this->storageManagerService->deleteFromCloudinary($public_ids);
        }

        // delete all posts of company

        $isDeleted = $this->company->find($id)->delete();
        if ($isDeleted) {
            return $this->navigationManagerService->redirectRoute('admin.company.index', [], 302, [], false, ["success" => "Company is deleted"]);
        }
        return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "Company is not deleted"]);
    }

    public function toggleVerified($id, $is_verified)
    {
        if (!$this->authenticableService->isAdmin()) {
            return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "You are not authorized"]);
        }
        $company = $this->company->find($id);
        if (!$company) {
            return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "Company is not found"]);
        }
        if ($is_verified == 1) {
            $company->is_verified = 0;
            $company->save();

            $details = [
                'title' => 'Company is unverified',
                'body' => "Your company is unverified by admin, please contact admin"
            ];
            // UNCOMMENT: To send notification
            $this->notifiableService->sendNotification($company, $details['body']);
            // UNCOMMENT: To send mail
            $this->mailableService->sendMail($company->email, $details);
            return $this->navigationManagerService->redirectBack(302, [], false, ["success" => "Company is unverified"]);
        } else {
            $company->is_verified = 1;
            $company->save();
            $details = [
                'title' => 'Company is verified',
                'body' => "Your company is verified by admin, now you can post jobs"
            ];
            // UNCOMMENT: To send notification
            $this->notifiableService->sendNotification($company, $details['body']);
            // UNCOMMENT: To send mail
            $this->mailableService->sendMail($company->email, $details);
            return $this->navigationManagerService->redirectBack(302, [], false, ["success" => "Company is verified"]);
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
            return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "Company is not found"]);
        }

        if ($company->profile_image_url) {
            $public_ids = $company->profile_image_public_id;
            $this->storageManagerService->deleteFromCloudinary($public_ids);
        }
        // CloudStorageManager : To upload image to cloudinary
        $this->storageManagerService->uploadToCloudinary($request, "COMPANY", $company->id);

        $data = [
            "profile_image_public_id" => null,
            "profile_image_url" => null,
        ];

        $isUpdated = $company->update($data);

        if ($isUpdated) {
            return $this->navigationManagerService->redirectBack(302, [], false, ["success" => "Company profile image is updated"]);
        }

        return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "Company profile image is not updated"]);
    }

    public function deleteProfileImage($id)
    {
        $company = $this->company->find($id);
        if (!$company) {
            return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "Company is not found"]);
        }
        if ($company->profile_image_url) {
            $public_ids = $company->profile_image_public_id;
            $this->storageManagerService->deleteFromCloudinary($public_ids);

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
            return $this->navigationManagerService->redirectBack(302, [], false, ["success" => "Company profile image is deleted"]);
        }
        return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "Company profile image is not deleted"]);
    }
}
