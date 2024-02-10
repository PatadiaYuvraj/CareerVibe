<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Company;
use App\Services\AuthenticableService;
use App\Services\MailableService;
use App\Services\NavigationManagerService;
use App\Services\NotifiableService;
use App\Services\StorageManagerService;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    private StorageManagerService $storageManagerService;
    private NotifiableService $notifiableService;
    private MailableService $mailableService;
    private NavigationManagerService $navigationManagerService;
    private AuthenticableService $authenticableService;
    private Company $company;

    public function __construct(
        Company $company,
        NotifiableService $notifiableService,
        MailableService $mailableService,
        StorageManagerService $storageManagerService,
        NavigationManagerService $navigationManagerService,
        AuthenticableService $authenticableService,
    ) {
        $this->company = $company;
        $this->notifiableService = $notifiableService;
        $this->mailableService = $mailableService;
        $this->storageManagerService = $storageManagerService;
        $this->navigationManagerService = $navigationManagerService;
        $this->authenticableService = $authenticableService;
    }

    public function login()
    {
        return $this->navigationManagerService->loadView('company.auth.login');
    }

    public function register()
    {
        return $this->navigationManagerService->loadView('company.auth.register');
    }

    public function doLogin(Request $request)
    {
        $request->validate([
            "email" => [
                "required",
                "email",
                function ($attribute, $value, $fail) {
                    $company = $this->authenticableService->getCompanyByEmail($value);
                    if (!$company) {
                        return $fail("Email does not exist");
                    }
                },
                // check email verification
                function ($attribute, $value, $fail) {
                    $company = $this->authenticableService->getCompanyByEmail($value);
                    if ($company && !$company->is_email_verified) {
                        return $fail("Email is not verified");
                    }
                }
            ],
            "password" => [
                "required",
                "min:8",
                "max:20",
                function ($attribute, $value, $fail) use ($request) {
                    $company = $this->authenticableService->getCompanyByEmail($request->get("email"));
                    if ($company && !$this->authenticableService->verifyPassword($value, $company->password)) {
                        return $fail("Password is incorrect");
                    }
                }
            ]
        ]);
        $data = [
            "email" => $request->get("email"),
            "password" => $request->get("password")
        ];

        // check emial verification
        $company = $this->authenticableService->getCompanyByEmail($data["email"]);
        if ($company && !$company->is_email_verified) {
            return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "Email is not verified"]);
        }

        if ($this->authenticableService->loginCompany($data)) {
            return $this->navigationManagerService->redirectRoute('company.dashboard', [], 302, [], false, ["success" => "You're Logged In"]);
        }
        return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "Invalid Credentials"]);
    }

    public function doRegister(Request $request)
    {
        $request->validate([
            "name" => [
                "required",
                "min:3",
                "max:50",
            ],
            "email" => [
                "required",
                "email",
                "unique:companies,email"
            ],
            "password" => [
                "required",
                "min:8",
                "max:20",
            ],
            "confirm_password" => [
                "required",
                "same:password"
            ]
        ]);

        $token = $this->authenticableService->generateEmailVerificationToken();
        $data = [
            "name" => $request->get("name"),
            "email" => $request->get("email"),
            "password" => $request->get("password"),
            "email_verification_token" => $token,
            'is_email_verified' => false,
        ];

        $details = [
            'username' => $data['name'],
            'url' => $this->authenticableService->generateUserEmailVerificationLink('company.verifyEmail', $token),
        ];



        // send mail
        $this->mailableService->emailVerificationMail($data['email'], $details);


        $isCreated = $this->authenticableService->registerCompany($data);

        if ($isCreated) {

            $company = $this->authenticableService->getCompanyById($isCreated->id);

            $details = [
                'title' => 'Account Created',
                'body' => "Your account is created successfully."
            ];
            // UNCOMMENT: To send notification
            $this->notifiableService->sendNotification($company, $details['body']);
            // UNCOMMENT: To send mail
            $this->mailableService->sendMail($company->email, $details);


            $admins = Admin::all();
            $details = [
                'title' => 'New Company Registered',
                'body' => "New company $company->name is registered. Please verify it."
            ];
            foreach ($admins as $admin) {
                // UNCOMMENT: To send notification
                $this->notifiableService->sendNotification($admin, $details['body']);
                // UNCOMMENT: To send mail
                $this->mailableService->sendMail($admin->email, $details);
            }

            return $this->navigationManagerService->redirectRoute('company.login', [], 302, [], false, ["success" => "Verification Link Sent To Your Email"]);
        }
        return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "Account Not Created"]);
    }

    public function verifyEmail($token)
    {
        $company = $this->company->where('email_verification_token', $token)->first();
        if (!$company) {
            return $this->navigationManagerService->redirectRoute('company.login', [], 302, [], false, ["warning" => "Invalid Token"]);
        }
        $data = [
            "is_email_verified" => true,
            "email_verification_token" => null,
            "email_verified_at" => now(),
        ];
        $isUpdated = $this->company->where('id', $company->id)->update($data);
        if ($isUpdated) {
            return $this->navigationManagerService->redirectRoute('company.login', [], 302, [], false, ["success" => "Email Verified Successfully"]);
        }
        return $this->navigationManagerService->redirectRoute('company.login', [], 302, [], false, ["warning" => "Email Not Verified"]);
    }

    public function forgotPassword()
    {
        return $this->navigationManagerService->loadView('company.auth.forgot-password');
    }

    public function doForgotPassword(Request $request)
    {
        $request->validate([
            "email" => [
                "required",
                "email",
                function ($attribute, $value, $fail) {
                    $company = $this->authenticableService->getCompanyByEmail($value);
                    if (!$company) {
                        return $fail("Email does not exist");
                    }
                },
                // check email verification
                function ($attribute, $value, $fail) {
                    $company = $this->authenticableService->getCompanyByEmail($value);
                    if ($company && !$company->email_verified_at) {
                        return $fail("Email is not verified");
                    }
                }
            ],
        ]);

        $token = $this->authenticableService->generatePasswordResetToken();
        $data = [
            "email" => $request->get("email"),
            "password_reset_token" => $token,
        ];

        $details = [
            'username' => $data['email'],
            'url' => $this->authenticableService->generateCompanyPasswordResetLink('company.resetPassword', $token),
        ];

        // send mail
        $this->mailableService->passwordResetMail($data['email'], $details);

        $isUpdated = $this->company->where('email', $data['email'])->update($data);

        if ($isUpdated) {
            return $this->navigationManagerService->redirectRoute('company.login', [], 302, [], false, ["success" => "Reset Password Link Sent To Your Email"]);
        }
        return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "Reset Password Link Not Sent"]);
    }

    public function resetPassword($token)
    {
        $company = $this->company->where('password_reset_token', $token)->first();
        if (!$company) {
            return $this->navigationManagerService->redirectRoute('company.login', [], 302, [], false, ["warning" => "Invalid Token"]);
        }
        return $this->navigationManagerService->loadView('company.auth.reset-password', compact('token'));
    }

    public function doResetPassword(Request $request, $token)
    {
        $request->validate([
            "password" => [
                "required",
                "min:8",
                "max:20",
            ],
            "confirm_password" => [
                "required",
                "same:password"
            ]
        ]);

        $company = $this->company->where('password_reset_token', $token)->first();
        if (!$company) {
            return $this->navigationManagerService->redirectRoute('company.login', [], 302, [], false, ["warning" => "Invalid Token"]);
        }

        $data = [
            // "password" => $request->get("password"),
            "password" => $this->authenticableService->passwordHash($request->get("password")), "password" => $this->authenticableService->passwordHash($request->get("password")),
            "password_reset_token" => null,
        ];

        $isUpdated = $this->company->where('id', $company->id)->update($data);

        if ($isUpdated) {
            return $this->navigationManagerService->redirectRoute('company.login', [], 302, [], false, ["success" => "Password Reset Successfully"]);
        }
        return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "Password Not Reset"]);
    }

    public function logout()
    {
        $this->authenticableService->logoutCompany();
        return $this->navigationManagerService->redirectRoute('company.login', [], 302, [], false, ["success" => "You're Logged Out"]);
    }

    public function dashboard()
    {
        return $this->navigationManagerService->loadView('company.dashboard.index');
    }

    public function changePassword()
    {
        return $this->navigationManagerService->loadView('company.auth.change-password');
    }

    public function doChangePassword(Request $request)
    {

        if (!$this->authenticableService->isCompany()) {
            return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "You are not authorized"]);
        }

        $id = $this->authenticableService->getCompany()->id;

        $request->validate([
            "currentPassword" => [
                "required",
                function ($attribute, $value, $fail) use ($id) {
                    $user = $this->company->find($id);
                    if (!$this->authenticableService->verifyPassword($value, $user->password)) {
                        return $fail(__('The current password is incorrect.'));
                    }
                }

            ],
            "newPassword" => [
                "required",
                "min:6",
                "max:20",
                function ($attribute, $value, $fail) use ($id) {
                    $user = $this->company->find($id);
                    if ($this->authenticableService->verifyPassword($value, $user->password)) {
                        return $fail(__('The new password cannot be same as current password.'));
                    }
                }
            ],
            "confirmPassword" => [
                "required",
                "min:6",
                "max:20",
                "same:newPassword"
            ]
        ]);

        $data = [
            "password" => $this->authenticableService->passwordHash($request->get("newPassword"))
        ];

        $isUpdated = $this->company->where('id', $id)->update($data);

        if ($isUpdated) {
            $company = $this->authenticableService->getCompany();
            $details = [
                'title' => 'Password Changed',
                'body' => "Your password has been changed successfully"
            ];
            // UNCOMMENT: To send notification
            $this->notifiableService->sendNotification($company, $details['body']);
            // UNCOMMENT: To send mail
            $this->mailableService->sendMail($company->email, $details);
            return $this->navigationManagerService->redirectRoute('company.dashboard', [], 302, [], false, ["success" => "Password Updated Successfully"]);
        }
        return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "Password Not Updated"]);
    }

    public function editProfile()
    {
        return $this->navigationManagerService->loadView('company.auth.edit-profile');
    }

    public function updateProfile(Request $request)
    {
        $company = $this->authenticableService->getCompany();
        $request->validate([
            "name" => [
                "required",
                "min:3",
                "max:50",
                function ($attribute, $value, $fail) use ($company) {
                    $user = $this->company->where("name", $value)->where("id", "!=", $company->id)->first();
                    if ($user) {
                        return $fail("Name already exist");
                    }
                }
            ],
            // "email" => [
            //     "required",
            //     "email",
            //     function ($attribute, $value, $fail) use ($company) {
            //         $user = $this->company->where("email", $value)->where("id", "!=", $company->id)->first();
            //         if ($user) {
            //             return $fail("Email already exist");
            //         }
            //     }
            // ]
        ]);

        $data = [
            "name" => $request->get("name"),
            // "email" => $request->get("email"),
        ];

        $data["website"] = $data["city"] = $data["address"] = $data["linkedin"] = $data["description"] = null;

        if ($request->get("website")) {
            $request->validate([
                "website" => [
                    "required",
                    "url",
                    "max:255",
                    function ($attribute, $value, $fail) {
                        $url = parse_url($value);
                        if (!isset($url['scheme'])) {
                            return $fail("The website format is invalid.");
                        }
                        if (!in_array($url['scheme'], ['http', 'https'])) {
                            return $fail("The website format is invalid.");
                        }
                    }

                ]
            ]);
            $data["website"] = $request->get("website");
        }

        if ($request->get("city")) {
            $request->validate([
                "city" => [
                    "required",
                    "string",
                    "max:255",
                ]
            ]);
            $data["city"] = $request->get("city");
        }

        if ($request->get("address")) {
            $request->validate([
                "address" => [
                    "required",
                    "string",
                    "max:255",
                ]
            ]);
            $data["address"] = $request->get("address");
        }

        if ($request->get("linkedin")) {
            $request->validate([
                "linkedin" => [
                    "required",
                    "url",
                    "max:255",
                    function ($attribute, $value, $fail) {
                        $url = parse_url($value);
                        if (!isset($url['scheme'])) {
                            return $fail("The linkedin format is invalid.");
                        }
                        if (!in_array($url['scheme'], ['http', 'https'])) {
                            return $fail("The linkedin format is invalid.");
                        }
                    }

                ]
            ]);
            $data["linkedin"] = $request->get("linkedin");
        }

        if ($request->get("description")) {
            $request->validate([
                "description" => [
                    "required",
                    "string",
                ]
            ]);
            $data["description"] = $request->get("description");
        }

        $isUpdated = $this->company->where('id', $company->id)->update($data);

        if ($isUpdated) {
            $company = $this->authenticableService->getCompany();
            $details = [
                'title' => 'Profile Updated',
                'body' => "Your profile has been updated successfully"
            ];
            $this->notifiableService->sendNotification($company, $details['body']);
            // UNCOMMENT: To send mail
            $this->mailableService->sendMail($company->email, $details);
            return $this->navigationManagerService->redirectRoute('company.dashboard', [], 302, [], false, ["success" => "Profile Updated Successfully"]);
        }
        return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "Profile Not Updated"]);
    }

    public function editProfileImage()
    {
        return $this->navigationManagerService->loadView('company.auth.edit-profile-image');
    }

    public function updateProfileImage(Request $request)
    {
        $id = $this->authenticableService->getCompany()->id;

        $request->validate([
            "profile_image_url" => [
                "required",
                "image",
                "mimes:jpeg,png,jpg",
                "max:2048",
            ],
        ]);

        $user = $this->company->find($id);

        if (!$user) {
            return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "User is not found"]);
        }

        if ($user->profile_image_url) {
            $public_ids = $user->profile_image_public_id;
            $this->storageManagerService->deleteFromCloudinary($public_ids);
        }

        $this->storageManagerService->uploadToCloudinary($request, "COMPANY", $user->id);

        $data = [
            "profile_image_public_id" => null,
            "profile_image_url" => null,
        ];

        $isUpdated = $this->company->where('id', $id)->update($data);
        if ($isUpdated) {

            $company = $this->authenticableService->getCompany();
            $details = [
                'title' => 'Profile Image Updated',
                'body' => "Your profile image has been updated successfully"
            ];
            // UNCOMMENT: To send notification
            $this->notifiableService->sendNotification($company, $details['body']);
            // UNCOMMENT: To send mail
            $this->mailableService->sendMail($company->email, $details);

            return $this->navigationManagerService->redirectRoute('company.dashboard', [], 302, [], false, ["success" => "Profile Image Updated Successfully"]);
        }
        return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "Profile Image Not Updated"]);
    }

    public function deleteProfileImage()
    {
        $id = $this->authenticableService->getCompany()->id;

        $user = $this->company->find($id);

        if (!$user) {
            return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "User is not found"]);
        }

        if ($user->profile_image_url) {
            $public_ids = $user->profile_image_public_id;
            $this->storageManagerService->deleteFromCloudinary($public_ids);
        }

        $data = [
            "profile_image_public_id" => null,
            "profile_image_url" => null,
        ];

        $isUpdated = $this->company->where('id', $id)->update($data);

        if ($isUpdated) {
            $company = $this->authenticableService->getCompany();
            $details = [
                'title' => 'Profile Image Deleted',
                'body' => "Your profile image has been deleted successfully"
            ];
            // UNCOMMENT: To send notification
            $this->notifiableService->sendNotification($company, $details['body']);
            // UNCOMMENT: To send mail
            $this->mailableService->sendMail($company->email, $details);
            return $this->navigationManagerService->redirectRoute('company.dashboard', [], 302, [], false, ["success" => "Profile Image Deleted Successfully"]);
        }
        return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "Profile Image Not Deleted"]);
    }
}
